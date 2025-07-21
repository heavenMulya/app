<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceManagementController extends Controller

{
     public function index()
    {
       // $agreement = DB::select('EXEC [RENTRIES].[SHOW_TENANT_AGREEMENT_MAPPING]');
        $invoice = DB::select('EXEC [RENTRIES].[SHOW_INVOICE_HDR]');
        $companies = DB::select('SELECT COMPANY_ID, COMPANY_NAME FROM [RENTAL].[RMASTER].[COMPANY_MASTER]');
          $dueList = DB::select('SELECT COMPANY_ID, COMPANY_NAME FROM [RENTAL].[RMASTER].[COMPANY_MASTER]');
         $tenants = DB::select('SELECT TENANT_ID,TENANT_NAME from RMASTER.TENANT');
         $building = DB::select('SELECT BUILDING_ID, BUILDING_NAME FROM [RENTAL].[RMASTER].[BUILDING_MASTER]');
                    $floor= DB::select('SELECT FLOOR_ID, FLOOR_NAME FROM [RENTAL].[RMASTER].[FLOOR_MASTER]');
                              $property = DB::select('SELECT PROPERTY_ID, PROPERTY_NAME FROM [RENTAL].[RMASTER].[PROPERTY_MASTER]');

     $defaultBranchId = 1;
     $details = DB::select('EXEC [RMASTER].[LOAD_bUILDING_FLOOR_PROPERTY_DETAILS] @BRANCH_ID = ?', [$defaultBranchId]);
        $branches = DB::select('EXEC [RMASTER].[LOAD_BRANCH_NAME_BRANCH_MASTER]');
          $rentaltypes = DB::select('EXEC [RMASTER].[LOAD_RENTAL_TYPE_NAME_RENTAL_TYPE]');
            $priceSetting = DB::select('EXEC [RMASTER].[LOAD_PRICE_SETTINGS]');

        $createdBy = auth()->user()->name ?? 'Admin';
        $macAddress = request()->ip();

        return view('Invoice.invoice', [
            //'agreement'     => $agreement,
             'invoice'     => $invoice,
             'dueList'     => $dueList,
            'branches'  => $branches,
           'details'  => $details,
              'tenants'  => $tenants,
               'building'=>$building,
           'floor'=>$floor,
           'property'=>$property,
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

public function getBranchDetails($id)
{
    try {
        $details = DB::select('EXEC [RMASTER].[LOAD_bUILDING_FLOOR_PROPERTY_DETAILS] @BRANCH_ID = ?', [$id]);
        return response()->json($details);
    } catch (\Exception $e) {
        // Log the error for backend debugging
        \Log::error('Error fetching branch details: ' . $e->getMessage());
        
        // Return error message in JSON so frontend can see it
        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function getNextDueDetails(Request $request)
{
    try {
        $details = DB::select('EXEC [RENTRIES].[GET_NEXT_DUE_DETAILS] 
            @PAYMENT_FOR = ?, 
            @BRANCH_ID = ?, 
            @TENANT_ID = ?, 
            @BUILDING_ID = ?, 
            @FLOOR_ID = ?, 
            @PROPERTY_ID = ?', [
                $request->payment_for,
                $request->branch_id,
                $request->tenant_id,
                $request->building_id,
                $request->floor_id,
                $request->property_id
            ]);

        return response()->json($details);

    } catch (\Exception $e) {
        \Log::error('Error fetching due details: ' . $e->getMessage());
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


public function getAgreementId(int $tenantId, int $propertyId)
{
    try {
        // Execute stored procedure
        $result = DB::select(
            'EXEC [RENTRIES].[GET_AGREEMENT_ID_USING_TENANT_ID_PROPERTY_ID] @TENANT_ID = ?, @PROPERTY_ID = ?',
            [$tenantId, $propertyId]
        );

        return response()->json($result);
    } catch (\Exception $e) {
        Log::error('Error fetching agreement ID: ' . $e->getMessage());

        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}

public function showTenantDocument($DOC_ID)
{
    $docs = DB::select('EXEC [RENTRIES].[GET_TENANT_AGREEMENT_DOCUMENTS] @DOC_ID = ?', [$DOC_ID]);
    return view('Tenants.document', ['documents' => $docs]);
}


public function createDocumentsAgreement(Request $request)
{
    $request->validate([
        'agreement_id'     => 'required|integer',
        'tenant_id'        => 'required|integer',
        'document_name'    => 'required|string',
        'FILE'             => 'required|file|mimes:pdf,jpg,png|max:2048',
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



public function create(Request $request)
{

    // dd($request->all());
    $request->validate([
        'invoice_no'                     => 'nullable|string|max:50',
        'invoice_date'                   => 'required|date',
        'payment_for'                    => 'required|string|max:50',
        'tenant_id'                      => 'required|integer',
        'branch_id'                      => 'required|integer',
        'building_id'                    => 'required|integer',
        'floor_id'                       => 'required|integer',
        'property_id'                    => 'required|integer',
        'due_id'                         => 'required|integer',
        'due_month'                      => 'required|string|max:50',
        'due_year'                       => 'required|integer',
        'due_amount'                     => 'required|numeric',
        'invoice_amount_with_vat'        => 'required|numeric',
        'total_amount'                   => 'required|numeric',
        'vat_percentage'                 => 'required|numeric',
        'vat_amount'                     => 'required|numeric',
        'with_holding_percentage'        => 'required|numeric',
        'total_income_after_withholding_tax' => 'required|numeric',
        'payment_type'                   => 'required|string|max:50',
        'remarks'                        => 'nullable|string|max:256',
        'status_master'                  => 'required|string',
        'agreement_id'=>'required|integer',
    ]);

    $macAddress = $request->ip();
    $user       = auth()->user()->name ?? 'admin';

    $invoiceId = null;

    $result = DB::select(
        'EXEC [RENTRIES].[SAVE_INVOICE_HDR] 
            @INVOICE_ID = ?, 
            @INVOICE_NO = ?, 
            @INVOICE_DATE = ?, 
            @PAYMENT_FOR = ?, 
            @TENANT_ID = ?, 
            @BRANCH_ID = ?, 
            @BUILDING_ID = ?, 
            @FLOOR_ID = ?, 
            @PROPERTY_ID = ?, 
            @DUE_ID = ?, 
            @DUE_MONTH = ?, 
            @DUE_YEAR = ?, 
            @DUE_AMOUNT = ?, 
            @INVOICE_AMOUNT_WITH_VAT = ?, 
            @TOTAL_AMOUNT = ?, 
            @VAT_PERCENTAGE = ?, 
            @VAT_AMOUNT = ?, 
            @WITH_HOLDING_PERCENTAGE = ?, 
            @TOTAL_INCOME_AFTER_WITH_HOLDING_TAX = ?, 
            @PAYMENT_TYPE = ?, 
            @REMARKS = ?, 
            @STATUS_MASTER = ?, 
            @CREATED_BY = ?, 
            @CREATED_MAC_ADDRESS = ?,
            @AGREEMENT_ID=?',
        [
            &$invoiceId,
            $request->invoice_no,
            $request->invoice_date,
            $request->payment_for,
            $request->tenant_id,
            $request->branch_id,
            $request->building_id,
            $request->floor_id,
            $request->property_id,
            $request->due_id,
            $request->due_month,
            $request->due_year,
            $request->due_amount,
            $request->invoice_amount_with_vat,
            $request->total_amount,
            $request->vat_percentage,
            $request->vat_amount,
            $request->with_holding_percentage,
            $request->total_income_after_withholding_tax,
            $request->payment_type,
            $request->remarks,
            $request->status_master,
            $user,
            $macAddress,
            $request->agreement_id,
        ]
    );

    $response   = $result[0] ?? null;
    $status     = $response->Column1 ?? '';
    $message    = $response->Column2 ?? '';
    $savedId    = $response->Column3 ?? null;

    return redirect()->route('invoice')->with([
        'message'  => $message,
        'status'   => $status,
        'saved_id' => $savedId
    ]);
}


    /**
     * Update the specified branch.
     */
   public function update(Request $request)
{
    $request->validate([
        'invoice_id'                      => 'required|integer',
        'invoice_no'                      => 'required|string|max:50',
        'invoice_date'                    => 'required|date',
        'payment_for'                     => 'required|string|max:50',
        'tenant_id'                       => 'required|integer',
        'branch_id'                       => 'required|integer',
        'building_id'                     => 'required|integer',
        'floor_id'                        => 'required|integer',
        'property_id'                     => 'required|integer',
        'due_id'                          => 'required|integer',
        'due_month'                       => 'required|string|max:50',
        'due_year'                        => 'required|integer',
        'due_amount'                      => 'required|numeric',
        'invoice_amount_with_vat'         => 'required|numeric',
        'total_amount'                    => 'required|numeric',
        'vat_percentage'                  => 'required|numeric',
        'vat_amount'                      => 'required|numeric',
        'with_holding_percentage'         => 'required|numeric',
        'total_income_after_withholding_tax' => 'required|numeric',
        'payment_type'                    => 'required|string|max:50',
        'remarks'                         => 'nullable|string|max:256',
        'status_master'                   => 'required|string',
    ]);

    $macAddress = $request->ip();
    $user       = auth()->user()->name ?? 'admin';

    try {
        $result = DB::select(
            'EXEC [RENTRIES].[UPDATE_INVOICE_HDR] 
                @INVOICE_ID = ?, 
                @INVOICE_NO = ?, 
                @INVOICE_DATE = ?, 
                @PAYMENT_FOR = ?, 
                @TENANT_ID = ?, 
                @BRANCH_ID = ?, 
                @BUILDING_ID = ?, 
                @FLOOR_ID = ?, 
                @PROPERTY_ID = ?, 
                @DUE_ID = ?, 
                @DUE_MONTH = ?, 
                @DUE_YEAR = ?, 
                @DUE_AMOUNT = ?, 
                @INVOICE_AMOUNT_WITH_VAT = ?, 
                @TOTAL_AMOUNT = ?, 
                @VAT_PERCENTAGE = ?, 
                @VAT_AMOUNT = ?, 
                @WITH_HOLDING_PERCENTAGE = ?, 
                @TOTAL_INCOME_AFTER_WITH_HOLDING_TAX = ?, 
                @PAYMENT_TYPE = ?, 
                @REMARKS = ?, 
                @STATUS_MASTER = ?, 
                @MODIFIED_BY = ?, 
                @UPDATED_MAC_ADDRESS = ?
                ',
            [
                $request->invoice_id,
                $request->invoice_no,
                $request->invoice_date,
                $request->payment_for,
                $request->tenant_id,
                $request->branch_id,
                $request->building_id,
                $request->floor_id,
                $request->property_id,
                $request->due_id,
                $request->due_month,
                $request->due_year,
                $request->due_amount,
                $request->invoice_amount_with_vat,
                $request->total_amount,
                $request->vat_percentage,
                $request->vat_amount,
                $request->with_holding_percentage,
                $request->total_income_after_withholding_tax,
                $request->payment_type,
                $request->remarks,
                $request->status_master,
                $user,
                $macAddress,
            ]
        );

        $response = $result[0] ?? null;
        $status   = $response->Column1 ?? '';
        $message  = $response->Column2 ?? '';

        return redirect()->route('invoice')->with([
            'message' => $message,
            'status'  => $status
        ]);
    } catch (\Exception $e) {
        return redirect()->route('invoice')->with([
            'message' => 'Update failed: ' . $e->getMessage(),
            'status'  => 'Error'
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
