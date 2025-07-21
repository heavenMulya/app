
@include ('layout.header')

@include ('layout.navbar')
@include ('layout.sidebar')

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Agreement Mapping List</h4>
                <h6>Manage your Agreement Mapping</h6>
            </div>


            @if(isset($message))
                <div id="session-alert" class="alert alert-{{ $status === 'Error' ? 'danger' : 'success' }} alert-dismissible fade show"
                     role="alert"
                     style="position: fixed; top: 90px; right: 500px; z-index: 1055; min-width: 450px;">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            @endif

            @if ($errors->count() > 0)
            
    @foreach ($errors->all() as $error)
        <div id="session-alert" class="alert alert-danger alert-dismissible fade show"
             role="alert"
             style="position: fixed; top: 90px; right: 500px; z-index: 1055; min-width: 450px;">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif

            <div class="page-btn">
                <a href="javascript:void(0);" class="btn btn-added add-btn"  data-bs-toggle="modal" data-bs-target="#addModal">
                    <img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add New Agreement Mapping
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter" id="filter_search">
                                <img src="assets/img/icons/filter.svg" alt="img">
                                <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                            </a>
                        </div>
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                    <img src="assets/img/icons/pdf.svg" alt="img">
                                </a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel">
                                    <img src="assets/img/icons/excel.svg" alt="img">
                                </a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                    <img src="assets/img/icons/printer.svg" alt="img">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-0" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th>Agreement Mapping Type</th>
                                       <th>Tenant</th>
                           
                                  <th>Branch</th>
                                
                                   <th>Floor</th>
                                    <th>Property</th>   
                                         <th>Rental Amount</th>  
                                            <th>Status</th>     
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>

  <tbody>
@foreach ($agreement as $item)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td>{{ $item->AGREEMENT_ID ?? 'N/A' }}</td>
        <td>{{ $item->AGREEMENT_TYPE ?? 'N/A' }}</td>
        <td>{{ $item->TENANT_NAME ?? 'N/A' }}</td>
           <td>{{ $item->BRANCH_NAME ?? 'N/A' }}</td>
        <td>{{ $item->FLOOR_NAME ?? 'N/A' }}</td>
        <td>{{ $item->PROPERTY_NAME ?? 'N/A' }}</td>
          <td>{{ $item->RENTAL_AMOUNT ?? 'N/A' }}</td>
        <td>{{ $item->STATUS_MASTER ?? 'N/A' }}</td>
    <td>{{ $item->REMARKS ?? 'N/A' }}</td>

        <td>
         <a class="me-3 view-btn"
   href="javascript:void(0);"
   data-id="{{ $item->AGREEMENT_ID }}"
    data-oldId="{{ $item->OLD_AGREEMENT_ID }}"
   data-agreementType="{{ $item->AGREEMENT_TYPE }}"
   data-tenant="{{ $item->TENANT_NAME }}"
   data-branch="{{ $item->BRANCH_NAME }}"
    data-company="{{ $item->COMPANY_NAME }}"
   data-building="{{ $item->BUILDING_NAME }}"
   data-floor="{{ $item->FLOOR_NAME }}"
   data-property="{{ $item->PROPERTY_NAME }}"
   data-rental-type-id="{{ $item->RENTAL_TYPE_NAME }}"
   data-rental="{{ $item->RENTAL_AMOUNT }}"
   data-final-rent="{{ $item->FINAL_RENT_AMOUNT_WITH_VAT }}"
   data-from="{{ $item->AGREEMENT_FROM_DATE }}"
   data-to="{{ $item->AGREEMENT_TO_DATE }}"
   data-notice-days="{{ $item->NOTICE_PERIOD_DAYS }}"
   data-notice-status="{{ $item->NOTICE_PERIOD_STATUS }}"
   data-price-id="{{ $item->PRICE_ID }}"
   data-renewal="{{ $item->RENEWAL_PERCENTAGE }}"
   data-deposit="{{ $item->DEPOSIT_AMOUNT }}"
   data-vat-deposit="{{ $item->VAT_DEPOSIT_AMOUNT }}"
   data-final-deposit="{{ $item->FINAL_DEPOSIT_AMOUNT_WITH_VAT }}"
   data-maintenance="{{ $item->COMMON_MAINTENANCE_AMOUNT }}"
   data-total-rent="{{ $item->TOTAL_RENT_AMOUNT }}"
   data-vat-rent="{{ $item->VAT_RENT_AMOUNT }}"
   data-remarks="{{ $item->REMARKS }}"
   data-status="{{ $item->STATUS_MASTER }}"
    data-doc-id="{{ $item->AGREEMENT_ID ?? 'N/A' }}"
    data-file-path="{{ $item->FILE_PATH ??'N/A'}}"
     data-vat_percentage="{{ $item->VAT_PERCENTAGE ?? 'N/A' }}"
    data-with_holding_tax_percentage="{{ $item->WITH_HOLDING_TAX_PERCENTAGE ??'N/A'}}"
   data-bs-toggle="modal"
   data-bs-target="#viewAgreementMappingModal">
    <img src="assets/img/icons/eye.svg" alt="View">
</a>



<a class="me-3 edit-btn"
   href="javascript:void(0);"
   data-id="{{ $item->AGREEMENT_ID }}"
   data-oldId="{{ $item->OLD_AGREEMENT_ID }}"
  data-agreementType="{{ $item->AGREEMENT_TYPE }}"
   data-tenant="{{ $item->TENANT_ID }}"
    data-companyid="{{ $item->COMPANY_ID }}"
   data-branch="{{ $item->BRANCH_ID }}"
   data-building="{{ $item->BUILDING_ID }}"
   data-floor="{{ $item->FLOOR_ID }}"
   data-property="{{ $item->PROPERTY_ID }}"
   data-rental="{{ $item->RENTAL_AMOUNT }}"
   data-final-rent="{{ $item->FINAL_RENT_AMOUNT_WITH_VAT }}"
   data-from="{{ $item->AGREEMENT_FROM_DATE }}"
   data-to="{{ $item->AGREEMENT_TO_DATE }}"
   data-remarks="{{ $item->REMARKS }}"
   data-status="{{ $item->STATUS_MASTER }}"
   data-price="{{ $item->PRICE_ID }}"
   data-renewal="{{ $item->RENEWAL_PERCENTAGE }}"
   data-deposit="{{ $item->DEPOSIT_AMOUNT }}"
   data-vat-deposit="{{ $item->VAT_DEPOSIT_AMOUNT }}"
   data-final-deposit="{{ $item->FINAL_DEPOSIT_AMOUNT_WITH_VAT }}"
   data-maintenance="{{ $item->COMMON_MAINTENANCE_AMOUNT }}"
   data-total-rent="{{ $item->TOTAL_RENT_AMOUNT }}"
   data-vat-rent="{{ $item->VAT_RENT_AMOUNT }}"
   data-notice-days="{{ $item->NOTICE_PERIOD_DAYS }}"
   data-notice-status="{{ $item->NOTICE_PERIOD_STATUS }}"
   data-rental-type="{{ $item->RENTAL_TYPE_ID }}"
        data-vat_percentage="{{ $item->VAT_PERCENTAGE ?? 'N/A' }}"
    data-with_holding_tax_percentage="{{ $item->WITH_HOLDING_TAX_PERCENTAGE ??'N/A'}}"
   data-bs-toggle="modal"
   data-bs-target="#editAgreementModal">
    <img src="assets/img/icons/edit.svg" alt="Edit">
</a>



            <a class="confirm-text delete-agreement-btn" 
               href="javascript:void(0);" 
               data-id="{{ $item->AGREEMENT_ID }}"
                data-name="{{ $item->AGREEMENT_TYPE }}" 
               data-bs-toggle="modal" 
               data-bs-target="#deletebuldingModal">
                <img src="assets/img/icons/delete.svg" alt="Delete">
            </a>

               <a class="confirm-text add-document-btn" 
               href="javascript:void(0);" 
               data-id="{{ $item->AGREEMENT_ID }}"
                data-tenant="{{ $item->TENANT_ID }}" 
               data-bs-toggle="modal" 
               data-bs-target="#documentModal">
                <img src="assets/img/icons/plus.svg" alt="Delete">
            </a>
        </td>
    </tr>
@endforeach
</tbody>

                    </table>
                </div> <!-- .table-responsive -->
            </div> <!-- .card-body -->
        </div> <!-- .card -->
    </div> <!-- .content -->
</div> <!-- .page-wrapper -->


<!-- Document Preview Modal -->
<div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-labelledby="documentPreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="documentPreviewModalLabel">Document Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="documentPreviewContent">
        <p class="text-muted">Loading document...</p>
      </div>
    </div>
  </div>
</div>


<!-- Add Agreement Mapping Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModal">Add New Agreement Mapping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('agreement.save') }}">
    @csrf
    <div class="row">
        <!-- LEFT COLUMN -->

                  <div class="col-md-6 mb-3">
                        <label class="form-label">Company</label>
                        <select class="form-select" name="company_id" id="company_id" required>
                            <option value="">Select Company </option>
                            @foreach ($companies as $tenant)
                                <option value="{{ $tenant->COMPANY_ID }}">{{ $tenant->COMPANY_NAME }}</option>
                            @endforeach
                        </select>
                    </div>


      <div class="col-md-6 mb-3">
                <label class="form-label">Tenant</label>
                <select class="form-select" name="tenant_id" id="tenant_id" required>
                    <option value="">Select Tenant </option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->TENANT_ID }}">{{ $tenant->TENANT_NAME }}</option>
                    @endforeach
                </select>
            </div>

             <div class="col-md-6 mb-3">
    <label class="form-label">Agreement Type</label>
    <select class="form-select" name="agreement_type" id="agreement_type" required>
    </select>
</div>       

            <div class="col-md-6 mb-3">
                <label class="form-label">Branch</label>
                <select class="form-select" name="branch_id" id="branch_id" required>
                    <option value="">Select Branch </option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->BRANCH_ID }}">{{ $branch->BRANCH_NAME }}</option>
                    @endforeach
                </select>
            </div>

           <div class="col-md-6 mb-3">
    <label class="form-label">Building</label>
      <select class="form-select" name="building_id" id="building_id" required>
                   <option value="">Select Building </option>
         @foreach ($building as $branch)
                        <option value="{{ $branch->BUILDING_ID }}">{{ $branch->BUILDING_NAME }}</option>
                    @endforeach
    </select>
</div>


            <div class="col-md-6 mb-3">
                <label class="form-label">Floor</label>
                    <select class="form-select" name="floor_id" id="floor_id" required>
        <option value="">Select Floor</option>
          @foreach ($floor as $branch)
                        <option value="{{ $branch->FLOOR_ID }}">{{ $branch->FLOOR_NAME }}</option>
                    @endforeach
    </select>
            </div>

               <div class="col-md-6 mb-3">
                <label class="form-label">Property</label>
                    <select class="form-select" name="property_id" id="property_id" required>
        <option value="">Select Property </option>
            @foreach ($property as $branch)
                        <option value="{{ $branch->PROPERTY_ID }}">{{ $branch->PROPERTY_NAME }}</option>
                    @endforeach
    </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Rental Type</label>
                <select class="form-select" name="rental_type_id" id="rental_type_id" required>
                    <option value="">Select Rental Type </option>
                    @foreach ($rentaltypes as $type)
                        <option value="{{ $type->RENTAL_TYPE_ID }}">{{ $type->RENTAL_TYPE_NAME }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Agreement From Date</label>
                <input type="date" class="form-control" name="agreement_from_date" id="agreement_from_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Agreement To Date</label>
                <input type="date" class="form-control" name="agreement_to_date" id="agreement_to_date"  required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Notice Period (Days)</label>
                <input type="number" class="form-control" name="notice_period_days" id="notice_period_days"  required>
            </div>
    <div class="col-md-6 mb-3">
                <label class="form-label">Notice Period Status</label>
<select class="form-select" name="notice_period_status" id="notice_period_status" required>

</select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Price Reference</label>
                <select class="form-select" name="price_id" id="price_id" required>

                </select>
            </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-6 mb-3" id="renewalPercentageContainer" style="display: none;">
    <label class="form-label">Renewal %</label>
    <input type="number" class="form-control renewalPercentId" name="renewal_percentage" id="renewal_percentage" oninput="calculateAll()" step="0.01">
</div>

          <div class="col-md-6 mb-3">
                <label class="form-label">Rental Amount</label>
                <input type="number" class="form-control" name="rental_amount" id="rental_amount" step="0.01" oninput="calculateAll()" required>
            </div>

               <div class="col-md-6 mb-3">
                <label class="form-label">Common Maintenance</label>
                <input type="number" class="form-control" name="common_maintenance_amount" id="common_maintenance_amount" step="0.01" oninput="calculateAll()" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Total Rent Amount</label>
                <input type="number" class="form-control" name="total_rent_amount" id="total_rent_amount" step="0.01"  required readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">VAT Rent Amount</label>
                <input type="number" class="form-control" name="vat_rent_amount" id="vat_rent_amount" step="0.01" required readonly>
            </div>
         
                  <div class="col-md-6 mb-3">
                <label class="form-label">Final Rent (with VAT)</label>
                <input type="number" class="form-control" name="final_rent_amount_with_vat" id="final_rent_amount_with_vat" step="0.01" required readonly> 
            </div>
             
              <div class="col-md-6 mb-3">
                <label class="form-label">Deposit Amount</label>
                <input type="number" class="form-control" name="deposit_amount" id="deposit_amount" step="0.01" required oninput="calculateAll()">
            </div>
        
            
            <div class="col-md-6 mb-3">
                <label class="form-label">VAT on Deposit</label>
                <input type="number" class="form-control" name="vat_deposit_amount" id="vat_deposit_amount" step="0.01" required readonly>
            </div>

       <div class="col-md-6 mb-3">
                <label class="form-label">Final Deposit (with VAT)</label>
                <input type="number" class="form-control" name="final_deposit_amount_with_vat" id="final_deposit_amount_with_vat" step="0.01" required readonly>
            </div>
            
      
                                    <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">VAT Percentage</label>
                            <input type="number" class="form-control" name="vat_percentage" id="vat_percentage" step="0.01" required readonly>
                        </div>
              
                       <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">WITH HOLDING TAX PERCENTAGE</label>
                            <input type="number" class="form-control" name="With_holding_vat_percentage" id="With_holding_vat_percentage" step="0.01" required readonly>
                        </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Remarks</label>
                <input type="text" class="form-control" name="remarks" id="remarks" maxlength="256">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
<!-- Status -->
<select class="form-select" name="status_master" id="status_master" required>
</select>
            </div>

             

        </div>
    </div>

    <!-- Hidden Metadata -->
      <input type="text" name="old_agreement_id" id="agreement_id">
    <input type="hidden" name="created_by" value="{{ $createdBy }}">
    <input type="hidden" name="modified_by" value="{{ $createdBy }}">
    <input type="hidden" name="created_mac_address" value="{{ $macAddress }}">
    <input type="hidden" name="updated_mac_address" value="{{ $macAddress }}">
    <input type="hidden" name="created_date" value="{{ now() }}">
    <input type="hidden" name="modified_date" value="{{ now() }}">

    <!-- Modal Footer -->
    <div class="modal-footer mt-4">
        <button type="submit" class="btn btn-primary">Save Agreement</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>

            </div>
        </div>
    </div>
</div>

<!-- Edit Agreement Mapping Modal -->
<!-- Edit Agreement Modal -->
<div class="modal fade" id="editAgreementModal" tabindex="-1" aria-labelledby="editAgreementLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Agreement Mapping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editAgreementForm" method="POST" action="{{ route('agreement.update') }}">
                @csrf

                <div class="modal-body">
                    <div class="row">

                    <!-- AGREEMENT_TYPE -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Agreement Type</label>
                        <select class="form-select" name="agreement_type" id="edit_agreement_type" required disabled>
                        </select>
                    </div>




                    <!-- TENANT -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tenant</label>
                        <select class="form-select" name="tenant_id" id="edit_tenant_id" required>
                            <option value="">Select Tenant </option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->TENANT_ID }}">{{ $tenant->TENANT_NAME }}</option>
                            @endforeach
                        </select>
                    </div>
         <div class="col-md-6 mb-3">
                        <label class="form-label">Company</label>
                        <select class="form-select" name="company_id" id="edit_company_id" required>
                            <option value="">Select Company </option>
                            @foreach ($companies as $tenant)
                                <option value="{{ $tenant->COMPANY_ID }}">{{ $tenant->COMPANY_NAME }}</option>
                            @endforeach
                        </select>
                    </div>
                  
                    <!-- BRANCH -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select class="form-select" name="branch_id" id="edit_branch_id" required>
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->BRANCH_ID }}">{{ $branch->BRANCH_NAME }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BUILDING -->
                 
               <div class="col-md-6 mb-3">
    <label class="form-label">Building</label>
    <select class="form-select" name="building_id" id="edit_building_id" required>
        <option value="">Select Building</option>
        @foreach ($building as $branch)
            <option value="{{ $branch->BUILDING_ID }}">{{ $branch->BUILDING_NAME }}</option>
        @endforeach
    </select>
</div>


<!-- FLOOR -->

     <div class="col-md-6 mb-3">
                <label class="form-label">Floor</label>
                    <select class="form-select" name="floor_id" id="edit_floor_id" required>
        <option value="">Select Floor</option>
          @foreach ($floor as $branch)
                        <option value="{{ $branch->FLOOR_ID }}">{{ $branch->FLOOR_NAME }}</option>
                    @endforeach
    </select>
            </div>

                

                  

                    <!-- PROPERTY -->
          <div class="col-md-6 mb-3">
                <label class="form-label">Property</label>
                    <select class="form-select" name="property_id" id="edit_property_id" required>
        <option value="">Select Property</option>
            @foreach ($property as $branch)
                        <option value="{{ $branch->PROPERTY_ID }}">{{ $branch->PROPERTY_NAME }}</option>
                    @endforeach
    </select>
            </div>

                    <!-- RENTAL TYPE -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rental Type</label>
                        <select class="form-select" name="rental_type_id" id="edit_rental_type_id" required>
                            <option value="">Select Rental Type</option>
                            @foreach ($rentaltypes as $type)
                                <option value="{{ $type->RENTAL_TYPE_ID }}">{{ $type->RENTAL_TYPE_NAME }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- DATES -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Agreement From Date</label>
                        <input type="date" class="form-control" name="agreement_from_date" id="edit_agreement_from_date" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Agreement To Date</label>
                        <input type="date" class="form-control" name="agreement_to_date" id="edit_agreement_to_date" required>
                    </div>

                    <!-- NOTICE PERIOD -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Notice Period (Days)</label>
                        <input type="number" class="form-control" name="notice_period_days" id="edit_notice_period_days" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Notice Period Status</label>
                        <select class="form-select" name="notice_period_status" id="edit_notice_period_status" required>
                       
                    </select>
                    </div>

                    <!-- PRICE ID -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price Reference</label>
                        <select class="form-select" name="price_id" id="edit_price_id" required>
                            <option value=""> Select Price ID </option>
                            @foreach ($priceSetting as $price)
                                <option value="{{ $price->PRICE_ID }}">{{ $price->RENTAL_AMOUNT }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- AMOUNTS -->
                            <div class="col-md-6 mb-3" id="edit_renewalPercentageContainer" style="display: none;">
                            <label class="form-label">Renewal %</label>
                            <input type="number" class="form-control" name="renewal_percentage" id="edit_renewal_percentage" step="0.01" oninput="calculateAll()">
                        </div>

                            <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">Rental Amount</label>
                            <input type="number" class="form-control" name="rental_amount" id="edit_rental_amount" step="0.01" required oninput="calculateAll()">
                        </div>

                        <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">Common Maintenance</label>
                            <input type="number" class="form-control" name="common_maintenance_amount" id="edit_common_maintenance_amount" step="0.01" required oninput="calculateAll()">
                        </div>

                        <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">Total Rent Anount</label>
                            <input type="number" class="form-control" name="total_rent_amount" id="edit_total_rent_amount" step="0.01" required readonly>
                        </div>

                                           <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">VAT on Rent Amount</label>
                            <input type="number" class="form-control" name="vat_rent_amount" id="edit_vat_rent_amount" step="0.01" required readonly>
                        </div>

                            

                        <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">Final Rent Amount (with VAT)</label>
                            <input type="number" class="form-control" name="final_rent_amount_with_vat" id="edit_final_rent_amount_with_vat" step="0.01" required readonly>
                        </div>

                        <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">Deposit Amount</label>
                            <input type="number" class="form-control" name="deposit_amount" id="edit_deposit_amount" step="0.01" required oninput="calculateAll()">
                        </div>

                        <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">VAT on Deposit Amount</label>
                            <input type="number" class="form-control" name="vat_deposit_amount" id="edit_vat_deposit_amount" step="0.01" required readonly>
                        </div>

                        <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">Final Deposit Amount(with VAT)</label>
                            <input type="number" class="form-control" name="final_deposit_amount_with_vat" id="edit_deposit_amount_with_vat" step="0.01" required readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">VAT Percentage</label>
                            <input type="number" class="form-control" name="vat_percentage" id="edit_vat_percentage" step="0.01" required readonly>
                        </div>
              
                       <div class="col-md-6 col-md-6 mb-3">
                            <label class="form-label">WITH HOLDING TAX PERCENTAGE</label>
                            <input type="number" class="form-control" name="With_holding_vat_percentage" id="edit_With_holding_vat_percentage" step="0.01" required readonly>
                        </div>
                   
                    <!-- REMARKS -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="edit_remarks" maxlength="256">
                    </div>

                    <!-- STATUS -->

                                            <div class="col-md-6 col-md-6 mb-3">
                            <label for="edit_status_master" class="form-label">Status</label>
                            <select class="form-select" id="edit_status_master" name="status_master">

                            </select>
                        </div>

                    <!-- HIDDEN FIELDS -->
                    <input type="text" name="old_agreement_id" id="edit_old_agreement_id">
                    <input type="hidden" name="agreement_id" id="edit_agreement_id">
                    <input type="hidden" name="created_by" value="{{ $createdBy }}">
                    <input type="hidden" name="modified_by" value="{{ $createdBy }}">
                    <input type="hidden" name="created_mac_address" value="{{ $macAddress }}">
                    <input type="hidden" name="updated_mac_address" value="{{ $macAddress }}">
                    <input type="hidden" name="created_date" value="{{ now() }}">
                    <input type="hidden" name="modified_date" value="{{ now() }}">
            
     
                <div class="modal-footer mt-3">
                    <button type="submit" class="btn btn-primary">Update Agreement</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
                </div></div>
            </form>
        </div>
    </div>
</div>


<!-- View Agreement Mapping Modal -->
<div class="modal fade" id="viewAgreementMappingModal" tabindex="-1" aria-labelledby="viewAgreementMappingLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg  custom-modal-width">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewAgreementMappingLabel">Agreement Mapping Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <div class="row">
        <div class="col-md-6 col-md-6 mb-3">
          <label class="form-label">Agreement ID</label>
          <input type="text" class="form-control" id="view_agreement_id" readonly>
        </div>

        <div class="col-md-6 col-md-6 mb-3">
          <label class="form-label">Agreement Type</label>
          <input type="text" class="form-control" id="view_agreement_type" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Tenant</label>
          <input type="text" class="form-control" id="view_tenant_id" readonly>
        </div>
      <div class="col-md-6 mb-3">
          <label class="form-label">Company</label>
          <input type="text" class="form-control" id="view_company_id" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Branch</label>
          <input type="text" class="form-control" id="view_branch_id" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Building</label>
          <input type="text" class="form-control" id="view_building_id" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Floor</label>
          <input type="text" class="form-control" id="view_floor_id" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Property</label>
          <input type="text" class="form-control" id="view_property_id" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Rental Type</label>
          <input type="text" class="form-control" id="view_rental_type_id" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Agreement From Date</label>
          <input type="text" class="form-control" id="view_agreement_from_date" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Agreement To Date</label>
          <input type="text" class="form-control" id="view_agreement_to_date" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Notice Period (Days)</label>
          <input type="text" class="form-control" id="view_notice_period_days" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Notice Period Status</label>
          <input type="text" class="form-control" id="view_notice_period_status" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Renewal Percentage</label>
          <input type="text" class="form-control" id="view_renewal_percentage" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Deposit Amount</label>
          <input type="text" class="form-control" id="view_deposit_amount" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">VAT on Deposit</label>
          <input type="text" class="form-control" id="view_vat_deposit_amount" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Final Deposit (with VAT)</label>
          <input type="text" class="form-control" id="view_final_deposit_amount_with_vat" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Rental Amount</label>
          <input type="text" class="form-control" id="view_rental_amount" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Common Maintenance Amount</label>
          <input type="text" class="form-control" id="view_common_maintenance_amount" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Total Rent Amount</label>
          <input type="text" class="form-control" id="view_total_rent_amount" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">VAT on Rent</label>
          <input type="text" class="form-control" id="view_vat_rent_amount" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Final Rent (with VAT)</label>
          <input type="text" class="form-control" id="view_final_rent_amount_with_vat" readonly>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Remarks</label>
          <textarea class="form-control" id="view_remarks" rows="2" readonly></textarea>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Status</label>
          <input type="text" class="form-control" id="view_status_master" readonly>
        </div>

                </div>
         <div class="mb-3 mt-4" id="documentListContainer" >
    <label class="form-label fw-bold text-uppercase text-secondary">Tenants Agreements Documents Lists</label>
    
    @if(!empty($item->AGREEMENT_ID) && !empty($item->FILE_PATH))
        <div class="d-flex align-items-center gap-2 mt-1">
            <button type="button" 
                    class="btn btn-outline-primary btn-sm view-document-btn"
                    data-doc-name="{{ $item->DOCUMENT_NAME }}"
                    data-file-path="{{ asset($item->FILE_PATH) }}"
                    title="View Agreement Document"
                    data-bs-toggle="modal" 
                    data-bs-target="#documentPreviewModal">
                <i class="fas fa-eye me-1"></i> View Document
            </button>
            
            <span class="text-muted small">{{ $item->DOCUMENT_NAME }}</span>
        </div>
    @else
        <span class="text-muted fst-italic">No document available</span>
    @endif
</div>

 <div class="mb-3 mt-4" id="detailsListContainer" >
                </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Delete Agreement Mapping Modal -->
<div class="modal fade" id="deletebuldingModal" tabindex="-1" aria-labelledby="deletebuldingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('agreement.delete') }}">
            @csrf
            <input type="hidden" name="id" id="delete_Agreement_Mapping_id">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deletebuldingModalLabel">Confirm Agreement Mapping Deletion</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete <strong id="delete_Agreement_Mapping_name">Agreement Mapping A102</strong> from the system?</p>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!--Documents Agreement Mapping Modal -->


<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg custom-modal-width">
            <div class="modal-content">
                <div class="modal-header">
        <h5 class="modal-title" id="documentModal">Documents Upload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
                <div class="modal-body"> 
                     
        <form method="POST" action="{{ route('agreement.document.save') }}" enctype="multipart/form-data">

    @csrf
    <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tenant</label>
        <select class="form-select" name="tenant_id" id="view_tenant_id_for_document"  disabled>
            <option value=""> Select Tenant </option>
                        @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->TENANT_ID }}">{{ $tenant->TENANT_NAME }}</option>
                            @endforeach
        </select>
        <input type="hidden" name="tenant_id" id="hidden_tenant_id">
    </div>


    
<div class="col-md-6 mb-3">
    <label class="form-label">Agreement Id</label>
    <select class="form-select" name="agreement_id" id="view_agreement_id_for_document"  disabled>
        <option value="">Loading Agreements </option>
    </select>
     <input type="hidden" name="agreement_id" id="hidden_agreement_id">
</div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Document Name</label>
            <input type="text" class="form-control" name="document_name" id="document_name" required>
    </div>

     <div class="col-md-6 mb-3">
        <label class="form-label">Document Upload</label>
        <input type="file" class="form-control" name="FILE" id="FILE">
    </div>

    <!-- Remarks -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Remarks</label>
        <input type="text" class="form-control" name="remarks" maxlength="256">
    </div>

    <!-- Status -->
 <div class="col-md-6 col-md-6 mb-3">
                            <label for="doc_status_master" class="form-label">Status</label>
                            <select class="form-select" id="doc_status_master" name="status_master">

                            </select>
                        </div>

    <div class="modal-footer mt-4">
        <button type="submit" class="btn btn-primary">Save Document</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</form>
                </div>
            </div>
    </div>
</div>

@include ('layout.footer')

<script>
    // Parse the JSON from the <script type="application/json">
    const validationDataScript = document.getElementById('__validation-data');
    const validationData = JSON.parse(validationDataScript.textContent);

    const oldInput = validationData.oldInput || {};
    const validationErrors = validationData.validationErrors || {};

    console.log('Old Input:', oldInput);
    console.log('Validation Errors:', validationErrors);

    if (validationErrors.document_name) {
    const errorMsg = validationErrors.document_name[0];
    document.getElementById('document_name_error').innerText = errorMsg;
}



function calculateAll(prefix = '') {
    const getVal = (id) => parseFloat(document.getElementById(prefix + id)?.value) || 0;
    const setVal = (id, value) => {
        const el = document.getElementById(prefix + id);
        if (el) el.value = value.toFixed(2);
    };

    const rentalAmount = getVal('rental_amount');
    const maintenance = getVal('common_maintenance_amount');
    const vatPercentage = getVal('vat_percentage');
    const depositAmount = getVal('deposit_amount');
    const withHolding = getVal('With_holding_vat_percentage');

    // 1. TOTAL_RENT_AMOUNT = RENTAL_AMOUNT + COMMON_MAINTENANCE_AMOUNT
    const totalRent = rentalAmount + maintenance;
    setVal('total_rent_amount', totalRent);

    // 2. VAT_RENT_AMOUNT = TOTAL_RENT_AMOUNT * VAT_PERCENTAGE / 100
    const vatRent = totalRent * vatPercentage / 100;
    setVal('vat_rent_amount', vatRent);

    // 3. FINAL_RENT_AMOUNT_WITH_VAT = TOTAL_RENT_AMOUNT + VAT_RENT_AMOUNT
    const finalRentWithVAT = totalRent + vatRent;
    setVal('final_rent_amount_with_vat', finalRentWithVAT);

    // 4. TOTAL_INCOME_AFTER_WITH_HOLDING_TAX = TOTAL_RENT_AMOUNT * WITH_HOLDING_PERCENTAGE / 100
    const incomeAfterTax = totalRent * withHolding / 100;
    setVal('total_income_after_with_holding_tax', incomeAfterTax);

    // 5. VAT_DEPOSIT_AMOUNT = DEPOSIT_AMOUNT * VAT_PERCENTAGE / 100
    const vatDeposit = depositAmount * vatPercentage / 100;
    setVal('vat_deposit_amount', vatDeposit);

    // 6. FINAL_DEPOSIT_AMOUNT_WITH_VAT = VAT_DEPOSIT_AMOUNT + DEPOSIT_AMOUNT
    const finalDepositWithVAT = vatDeposit + depositAmount;
    setVal('final_deposit_amount_with_vat', finalDepositWithVAT);
}

</script>



</body>
</html>