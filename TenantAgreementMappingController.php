<?php

namespace App\Http\Controllers\Agreements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\DynamicStoredProcedureService;
use PhpParser\Node\Stmt\TryCatch;

class TenantAgreementMappingController extends Controller
{
     public function index()
    {
        $agreement = DB::select('EXEC [RENTRIES].[SHOW_TENANT_AGREEMENT_MAPPING]');
        $companies = DB::select('SELECT COMPANY_ID, COMPANY_NAME FROM [RENTAL].[RMASTER].[COMPANY_MASTER]');
          $building = DB::select('SELECT BUILDING_ID, BUILDING_NAME FROM [RENTAL].[RMASTER].[BUILDING_MASTER]');
                    $floor= DB::select('SELECT FLOOR_ID, FLOOR_NAME FROM [RENTAL].[RMASTER].[FLOOR_MASTER]');
                              $property = DB::select('SELECT PROPERTY_ID, PROPERTY_NAME FROM [RENTAL].[RMASTER].[PROPERTY_MASTER]');


         $tenants = DB::select('SELECT TENANT_ID,TENANT_NAME from RMASTER.TENANT');
     $defaultBranchId = 1;
$details = DB::select('EXEC [RMASTER].[LOAD_bUILDING_FLOOR_PROPERTY_DETAILS] @BRANCH_ID = ?', [$defaultBranchId]);

        $branches = DB::select('EXEC [RMASTER].[LOAD_BRANCH_NAME_BRANCH_MASTER]');
          $rentaltypes = DB::select('EXEC [RMASTER].[LOAD_RENTAL_TYPE_NAME_RENTAL_TYPE]');
            $priceSetting = DB::select('EXEC [RMASTER].[LOAD_PRICE_SETTINGS]');
            

        $createdBy = auth()->user()->name ?? 'Admin';
        $macAddress = request()->ip();

        return view('Agreements.TENANT_AGREEMENT_MAPPING', [
            'agreement'     => $agreement,
            'branches'  => $branches,
           'details'  => $details,
           'building'=>$building,
           'floor'=>$floor,
           'property'=>$property,
              'tenants'  => $tenants,
                'rentaltypes'  => $rentaltypes,
                  'priceSetting'  => $priceSetting,
            'companies'  => $companies,
            'createdBy'  => $createdBy,
            'macAddress' => $macAddress,
            'message'    => session('message'),
            'status'     => session('status')
        ]);
    }

    /**
     * Store a newly created branch in the database.
     */



public function LoadDocumentPath($id)
{
    try {
        // Execute stored procedure with the provided PRICE_ID
        $details = DB::select('EXEC [RENTRIES].[GET_TENANT_AGREEMENT_DOCUMENTS_DETAILS]  @AGREEMENT_ID = ?', [$id]);

        return response()->json($details);
    } catch (\Exception $e) {
        \Log::error('Error fetching price details: ' . $e->getMessage());

        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function LoadDetails($id)
{
    try {
        // Execute stored procedure with the provided PRICE_ID
        $details = DB::select('EXEC [RENTRIES].[SHOW_TENANT_SCHEDULE_DUE_RECORDS] @AGREEMENT_ID = ?', [$id]);

        return response()->json($details);
    } catch (\Exception $e) {
        \Log::error('Error fetching price details: ' . $e->getMessage());

        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function LoadInvoiceDetails($id)
{
    try {
        // Execute stored procedure with the provided PRICE_ID
        $details = DB::select('EXEC [RENTRIES].[show_INVOICE_DUE_MAPPING] @INVOICE_ID = ?', [$id]);

        return response()->json($details);
    } catch (\Exception $e) {
        \Log::error('Error fetching price details: ' . $e->getMessage());

        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function getPriceDetails($id)
{
    try {
        // Execute stored procedure with the provided PRICE_ID
        $details = DB::select('EXEC [RMASTER].[GET_PRICE_DETAIL_USING_PRICE_ID] @PRICE_ID = ?', [$id]);

        return response()->json($details);
    } catch (\Exception $e) {
        \Log::error('Error fetching price details: ' . $e->getMessage());

        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}


public function getAgreementByTenant($tenantId)
{
    try {
        // Call your stored procedure with tenant ID param
        $agreements = DB::select('EXEC [RENTRIES].[GET_AGREEMENT_ID_USING_TENANT_ID] @TENANT_ID = ?', [$tenantId]);

        return response()->json($agreements);
    } catch (\Exception $e) {
        \Log::error('Error fetching agreements: ' . $e->getMessage());

        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}
public function increaseVatUsingRenewal(Request $request)
{
    try {
        $agreementId = $request->input('agreement_id');
        $renewalPercentage = $request->input('renewal_percentage');
        $agreementType = $request->input('agreement_type');

        // Call your stored procedure or logic
        $result = DB::select('EXEC [RENTRIES].[Increase_Vat_Percentage_Using_Renewal_Percentage] ?, ?, ?', [
            $agreementType, $agreementId, $renewalPercentage
        ]);

        return response()->json(['success' => true, 'data' => $result]);
    } catch (\Exception $e) {
        \Log::error('Error in VAT update: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}


public function showInvoiceDetails(Request $request)
{
    try {
      $tenantId = $request->input('tenant_id'); 

        // Call your stored procedure or logic
        $result = DB::select('EXEC [RENTRIES].[GET_INVOICE_DETAILS_USING_TENANT_ID] ?', [
            $tenantId
        ]);

        return response()->json(['success' => true, 'data' => $result]);
    } catch (\Exception $e) {
        \Log::error('Error in Invoice Details update: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}

 

public function loadDropdownByFieldId(DynamicStoredProcedureService $spService)
{
    try {
        $fieldId = request()->input('id');

        if (!$fieldId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'FIELD_ID is required.'
            ], 400);
        }

        // Call the stored procedure
        $dropdownData = $spService->execute('[RMASTER].[LOAD_COMMON_DROPDOWN_DTL]', [
            'cOMMON_ID' => $fieldId
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => $dropdownData
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}



public function showTenantDocument($DOC_ID)
{
    $docs = DB::select('EXEC [RENTRIES].[GET_TENANT_AGREEMENT_DOCUMENTS] @DOC_ID = ?', [$DOC_ID]);
    return view('Tenants.document', ['documents' => $docs]);
}


public function getCommonDropdownDetails($id)
{
    try {
        // Call the stored procedure with the provided COMMON_ID
        $result = DB::select('EXEC [RMASTER].[LOAD_COMMON_DROPDOWN_DTL] @cOMMON_ID = ?', [$id]);

        // Return success response
        return response()->json($result);
        
    } catch (\Exception $e) {
        // Log the error for backend tracing
        Log::error('Error loading common dropdown details: ' . $e->getMessage());

        // Return error to frontend
        return response()->json([
            'error' => 'Failed to load dropdown details',
            'message' => $e->getMessage()
        ], 500);
    }
}


 public function loadTenantByCompanyID(Request $request)
    {
        $branchId = $request->input('company_id');

        try {
            $buildings = DB::select(
                'EXEC [RMASTER].[LOAD_TENANT_NAME_USING_COMPANY_ID] @COMPANY_ID = ?',
                [$branchId]
            );

            return response()->json([
                'success' => true,
                'data' => $buildings
            ]);
        } catch (\Exception $e) {
            Log::error('Error executing LOAD_BUILDING_NAME_USING_BRANCH_ID: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Unable to load buildings',
                'message' => $e->getMessage()
            ], 500);
        }
    }

 public function loadBranchByCompanyID(Request $request)
    {
        $branchId = $request->input('company_id');

        try {
            $buildings = DB::select(
                'EXEC RMASTER.LOAD_BRANCH_USING_COMPANY_ID @COMPANY_ID = ?',
                [$branchId]
            );

            return response()->json([
                'success' => true,
                'data' => $buildings
            ]);
        } catch (\Exception $e) {
            Log::error('Error executing LOAD_BUILDING_NAME_USING_BRANCH_ID: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Unable to load buildings',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function loadBuildingsByBranch(Request $request)
    {
        $branchId = $request->input('branch_id');

        try {
            $buildings = DB::select(
                'EXEC [RMASTER].[LOAD_BUILDING_NAME_USING_BRANCH_ID] @BRANCH_ID = ?',
                [$branchId]
            );

            return response()->json([
                'success' => true,
                'data' => $buildings
            ]);
        } catch (\Exception $e) {
            Log::error('Error executing LOAD_BUILDING_NAME_USING_BRANCH_ID: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Unable to load buildings',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getFloors(Request $request)
    {
        $branchId = $request->input('branch_id');
        $buildingId = $request->input('building_id');

        if (!$branchId || !$buildingId) {
            return response()->json([
                'success' => false,
                'error' => 'Missing branch_id or building_id.'
            ], 400);
        }

        try {
            $floors = DB::select(
                'EXEC [RMASTER].[LOAD_FLOOR_NAME_USING_BRANCH_ID_AND_BUILDING_ID] 
                 @BRANCH_ID = ?, @BUILDING_ID = ?',
                [$branchId, $buildingId]
            );

            return response()->json([
                'success' => true,
                'data' => $floors
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading floors: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function loadProperty(Request $request)
    {
        $branchId = $request->input('branch_id');
        $buildingId = $request->input('building_id');
        $floorId = $request->input('floor_id');

        if (!$branchId || !$buildingId || !$floorId) {
            return response()->json([
                'success' => false,
                'error' => 'Missing branch_id, building_id, or floor_id.'
            ], 400);
        }

        try {
            $properties = DB::select(
                'EXEC [RMASTER].[LOAD_PROPERTY_NAME_USING_BRANCH_ID_AND_BUILDING_ID_FLOOR_ID] 
                 @BRANCH_ID = ?, @BUILDING_ID = ?, @FLOOR_ID = ?',
                [$branchId, $buildingId, $floorId]
            );

            return response()->json([
                'success' => true,
                'data' => $properties
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading properties: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


      public function getPriceID(Request $request)
    {
        $rentalTypeId = $request->input('rental_type_id');
        $propertyId = $request->input('property_id');

        if (!$rentalTypeId || !$propertyId) {
            return response()->json([
                'success' => false,
                'error' => 'Missing property_id, rental_type_id.'
            ], 400);
        }

        try {
            $properties = DB::select(
                'EXEC RMASTER.GET_PRICE_USING_RENTAL_TYE_PROPERTY_ID  
                 @RENTAL_TYPE_ID = ?, @PROPERTY_ID = ?',
                [$rentalTypeId, $propertyId]
            );

            return response()->json([
                'success' => true,
                'data' => $properties
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading properties: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }





    public function showRenewalMapping(Request $request)
    {
        $agreementType = $request->input('agreement_type'); // e.g. "RENEWAL"
        $tenantId = $request->input('tenant_id');           // e.g. 123

        try {
            $data = DB::select(
                'EXEC [RENTRIES].[SHOW_RENEWAL_TENANT_AGREEMENT_MAPPING_USING_AGREEMENT_TYPE_AND_TENANT_ID] 
                 @AGREEMENT_TYPE = ?, @TENANT_ID = ?',
                [$agreementType, $tenantId]
            );

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching renewal agreement mapping: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    

public function createDocumentsAgreement(Request $request)
{
  
    try{
      $request->validate([
        'agreement_id'     => 'required|integer',
        'tenant_id'        => 'required|integer',
        'document_name'    => 'required|string',
        'FILE'             => 'required|file',
        'remarks'          => 'nullable|string|max:256',
        'status_master'    => 'required|string',
    ]);
 

    $file = $request->file('FILE');
    $fileName = time() . '_' . preg_replace('/\s+/', '_', strtolower($request->input('document_name'))) . '.' . $file->getClientOriginalExtension();
    $filePath = $file->storeAs('documents', $fileName, 'public');

    $createdBy  = auth()->user()->username ?? 'admin';
    $createdMac = $request->ip();

    $DOC_ID = null;

    $result = DB::select(
        'EXEC [RENTRIES].[SAVE_TENANT_AGREEMENT_DOCUMENTS]
            @DOC_ID = ?, 
            @AGREEMENT_ID = ?,  
            @TENANT_ID = ?, 
            @DOCUMENT_NAME = ?, 
            @FILE_PATH = ?,  
            @REMARKS = ?, 
            @CREATED_BY = ?, 
            @CREATED_MAC_ADDRESS = ?, 
            @STATUS_MASTER = ?',
        [
            $DOC_ID,
            $request->agreement_id,
            $request->tenant_id,
            $request->document_name,
            '/storage/' . $filePath,
            $request->remarks,
            $createdBy,
            $createdMac,
            $request->status_master
        ]
    );
  

    $response   = $result[0] ?? null;
    $status     = $response->Column1 ?? '';
    $message    = $response->Column2 ?? '';
    $savedId    = $response->Column3 ?? null;

    return redirect()->route('agreement')->with([
        'message'  => $message,
        'status'   => $status,
        'saved_id' => $savedId
    ]);
}
catch (\Exception $e) {
           Log::error('Error fetching renewal agreement mapping: ' . $e->getMessage());
         return redirect()->route('agreement')->with([
        'message'  => $e->getMessage(),
        'status'   => 'Error'
    ]);
    }
}



public function create(Request $request)
{
    $request->validate([
        'agreement_type'               => 'required|string',
        'tenant_id'                    => 'required|integer',
        'branch_id'                    => 'required|integer',
        'building_id'                  => 'required|integer',
        'floor_id'                     => 'required|integer',
        'property_id'                  => 'required|integer',
        'rental_type_id'              => 'required|integer',
        'agreement_from_date'          => 'required|date',
        'agreement_to_date'            => 'required|date',
        'notice_period_days'           => 'required|integer',
        'notice_period_status'         => 'required|string',
        'price_id'                     => 'required|integer',
        'renewal_percentage'           => 'nullable|numeric',
        'deposit_amount'               => 'required|numeric',
        'vat_deposit_amount'           => 'required|numeric',
        'final_deposit_amount_with_vat'=> 'required|numeric',
        'rental_amount'                => 'required|numeric',
        'common_maintenance_amount'    => 'required|numeric',
        'total_rent_amount'            => 'required|numeric',
        'vat_rent_amount'              => 'required|numeric',
        'final_rent_amount_with_vat'   => 'required|numeric',
        'remarks'                      => 'nullable|string|max:256',
        'status_master'                => 'required|string',
                 'vat_percentage'               => 'required|numeric',
          'With_holding_vat_percentage'               => 'required|numeric',
           'company_id'               => 'required|numeric',
               'old_agreement_id'               => 'required|numeric',
    ]);

    $macAddress = $request->ip();
    $user       = auth()->user()->name ?? 'admin';

    $agreementId = null;

    $result = DB::select(
        'EXEC [RENTRIES].[SAVE_TENANT_AGREEMENT_MAPPING] 
            @AGREEMENT_ID = ?, 
            @AGREEMENT_TYPE = ?, 
            @TENANT_ID = ?, 
            @BRANCH_ID = ?, 
            @BUILDING_ID = ?, 
            @FLOOR_ID = ?, 
            @PROPERTY_ID = ?, 
            @RENTAL_TYPE_ID = ?, 
            @AGREEMENT_FROM_DATE = ?, 
            @AGREEMENT_TO_DATE = ?, 
            @NOTICE_PERIOD_DAYS = ?, 
            @NOTICE_PERIOD_STATUS = ?, 
            @PRICE_ID = ?, 
            @RENEWAL_PERCENTAGE = ?, 
            @DEPOSIT_AMOUNT = ?, 
            @VAT_DEPOSIT_AMOUNT = ?, 
            @FINAL_DEPOSIT_AMOUNT_WITH_VAT = ?, 
            @RENTAL_AMOUNT = ?, 
            @COMMON_MAINTENANCE_AMOUNT = ?, 
            @TOTAL_RENT_AMOUNT = ?, 
            @VAT_RENT_AMOUNT = ?, 
            @FINAL_RENT_AMOUNT_WITH_VAT = ?, 
            @REMARKS = ?, 
            @USER = ?, 
            @MAC_ADDRESS = ?, 
            @STATUS_MASTER = ?,
                            @VAT_PERCENTAGE=?,
                @WITH_HOLDING_TAX_PERCENTAGE=?,
                @COMPANY_ID=?,
                @OLD_AGREEMENT_ID=?
                
                ',

        [
            &$agreementId,
            $request->agreement_type,
            $request->tenant_id,
            $request->branch_id,
            $request->building_id,
            $request->floor_id,
            $request->property_id,
            $request->rental_type_id,
            $request->agreement_from_date,
            $request->agreement_to_date,
            $request->notice_period_days,
            $request->notice_period_status,
            $request->price_id,
            $request->renewal_percentage ?? 0,
            $request->deposit_amount,
            $request->vat_deposit_amount,
            $request->final_deposit_amount_with_vat,
            $request->rental_amount,
            $request->common_maintenance_amount,
            $request->total_rent_amount,
            $request->vat_rent_amount,
            $request->final_rent_amount_with_vat,
            $request->remarks,
            $user,
            $macAddress,
            $request->status_master,
             $request->vat_percentage,
                      $request->With_holding_vat_percentage,
                      $request->company_id,
                       $request->old_agreement_id,

        ]
    );

    $response   = $result[0] ?? null;
    $status     = $response->Column1 ?? '';
    $message    = $response->Column2 ?? '';
    $savedId    = $response->Column3 ?? null;

    return redirect()->route('agreement')->with([
        'message' => $message,
        'status'  => $status,
        'saved_id' => $savedId
    ]);
}


    /**
     * Update the specified branch.
     */
    public function update(Request $request)
{

    try{
    $request->validate([
        'agreement_id'                 => 'required|integer',
        'agreement_type'               => 'required|string',
        'tenant_id'                   => 'required|integer',
        'branch_id'                   => 'required|integer',
        'building_id'                 => 'required|integer',
        'floor_id'                    => 'required|integer',
        'property_id'                 => 'required|integer',
        'rental_type_id'              => 'required|integer',
        'agreement_from_date'         => 'required|date',
        'agreement_to_date'           => 'required|date',
        'notice_period_days'          => 'required|integer',
        'notice_period_status'        => 'required|string',
        'price_id'                   => 'required|integer',
        'renewal_percentage'          => 'nullable|numeric',
        'deposit_amount'              => 'required|numeric',
        'vat_deposit_amount'          => 'required|numeric',
        'final_deposit_amount_with_vat' => 'required|numeric',
        'rental_amount'               => 'required|numeric',
        'common_maintenance_amount'  => 'required|numeric',
        'total_rent_amount'           => 'required|numeric',
        'vat_rent_amount'             => 'required|numeric',
        'final_rent_amount_with_vat'  => 'required|numeric',
        'remarks'                    => 'nullable|string|max:256',
        'status_master'               => 'required|string',
         'vat_percentage'               => 'required|numeric',
          'With_holding_vat_percentage'               => 'required|numeric',
             'company_id'               => 'required|numeric',
                 'old_agreement_id'               => 'required|numeric',
    ]);
}
catch (\Exception $e) {
           Log::error('Error fetching renewal agreement mapping: ' . $e->getMessage());
        
    }

 

    $macAddress = $request->ip();
    $user = auth()->user()->name ?? 'admin';

    try {
        $result = DB::select(
            'EXEC [RENTRIES].[UPDATE_TENANT_AGREEMENT_MAPPING] 
                @AGREEMENT_ID = ?, 
                @AGREEMENT_TYPE = ?, 
                @TENANT_ID = ?, 
                @BRANCH_ID = ?, 
                @BUILDING_ID = ?, 
                @FLOOR_ID = ?, 
                @PROPERTY_ID = ?, 
                @RENTAL_TYPE_ID = ?, 
                @AGREEMENT_FROM_DATE = ?, 
                @AGREEMENT_TO_DATE = ?, 
                @NOTICE_PERIOD_DAYS = ?, 
                @NOTICE_PERIOD_STATUS = ?, 
                @PRICE_ID = ?, 
                @RENEWAL_PERCENTAGE = ?, 
                @DEPOSIT_AMOUNT = ?, 
                @VAT_DEPOSIT_AMOUNT = ?, 
                @FINAL_DEPOSIT_AMOUNT_WITH_VAT = ?, 
                @RENTAL_AMOUNT = ?, 
                @COMMON_MAINTENANCE_AMOUNT = ?, 
                @TOTAL_RENT_AMOUNT = ?, 
                @VAT_RENT_AMOUNT = ?, 
                @FINAL_RENT_AMOUNT_WITH_VAT = ?, 
                @REMARKS = ?, 
                @USER = ?, 
                @MAC_ADDRESS = ?, 
                @STATUS_MASTER = ?,
                @VAT_PERCENTAGE=?,
                @WITH_HOLDING_TAX_PERCENTAGE=?,
                    @COMPANY_ID=?,
                    @OLD_AGREEMENT_ID=?
                ',
            [
                $request->agreement_id,
                $request->agreement_type,
                $request->tenant_id,
                $request->branch_id,
                $request->building_id,
                $request->floor_id,
                $request->property_id,
                $request->rental_type_id,
                $request->agreement_from_date,
                $request->agreement_to_date,
                $request->notice_period_days,
                $request->notice_period_status,
                $request->price_id,
                $request->renewal_percentage ?? 0,
                $request->deposit_amount,
                $request->vat_deposit_amount,
                $request->final_deposit_amount_with_vat,
                $request->rental_amount,
                $request->common_maintenance_amount,
                $request->total_rent_amount,
                $request->vat_rent_amount,
                $request->final_rent_amount_with_vat,
                $request->remarks,
                $user,
                $macAddress,
                $request->status_master,
                   $request->vat_percentage,
                      $request->With_holding_vat_percentage,
                       $request->company_id,
                        $request->old_agreement_id
            ]
        );

        $response = $result[0] ?? null;
        $status = $response->Column1 ?? '';
        $message = $response->Column2 ?? '';

        return redirect()->route('agreement')->with([
            'message' => $message,
            'status' => $status
        ]);
    } catch (\Exception $e) {
           Log::error('Error fetching renewal agreement mapping: ' . $e->getMessage());
        return redirect()->route('agreement')->with([
            'message' => 'Update failed: ' . $e->getMessage(),
            'status' => 'Error'
        ]);
    }
}


    /**
     * Remove the specified branch.
     */
    public function destroy(Request $request)
    {
        try {
            $result = DB::select(
                'EXEC [RENTRIES].[DELETE_TENANT_AGREEMENT_MAPPING] 
                    @AGREEMENT_ID = ?, 
                    @MODIFIED_BY = ?, 
                    @UPDATED_MAC_ADDRESS = ?',
                [
                    $request->input('id'),
                    auth()->user()->name ?? 'admin',
                    $request->ip()
                ]
            );

            $response   = $result[0] ?? null;
            $statusType = $response->Column1 ?? '';
            $message    = $response->Column2 ?? '';

            return redirect()->route('agreement')->with([
                'message' => $message,
                'status'  => $statusType ?: 'Success'
            ]);

        } catch (\Exception $e) {
            return redirect()->route('agreement')->with([
                'message' => 'Error: ' . $e->getMessage(),
                'status'  => 'Error'
            ]);
        }
    }
}
