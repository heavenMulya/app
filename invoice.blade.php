
@include ('layout.header')

@include ('layout.navbar')
@include ('layout.sidebar')

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Invoice List</h4>
                <h6>Manage your Invoice</h6>
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
                <a href="javascript:void(0);" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addModal">
                    <img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add New Invoice
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
                                <th>INVOICE_NO</th>
                                <th>INVOICE_DATE</th>
                                <th>PAYMENT_FOR</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>

  <tbody>
@foreach ($invoice as $item)
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>

        <td>{{ $item->id ?? 'N/A' }}</td>
        <td>{{ $item->INVOICE_NO ?? 'N/A' }}</td>
        <td>{{ $item->INVOICE_DATE ?? 'N/A' }}</td>
        <td>{{ $item->PAYMENT_FOR ?? 'N/A' }}</td>
        <td>{{ $item->REMARKS ?? 'N/A' }}</td>

        <td>
         <a class="me-3 view-btn"
   href="javascript:void(0);"
 data-invoice_id="{{ $item->id }}"
   data-invoice_no="{{ $item->INVOICE_NO }}"
   data-invoice_date="{{ $item->INVOICE_DATE }}"
   data-payment_for="{{ $item->PAYMENT_FOR }}"
   data-tenant_id="{{ $item->TENANT_NAME }}"
   data-branch_id="{{ $item->BRANCH_NAME }}"
    data-building_id="{{ $item->BUILDING_ID }}"
   data-building_name="{{ $item->BUILDING_NAME }}"
   data-floor_id="{{ $item->FLOOR_ID }}"
   data-floor_name="{{ $item->FLOOR_NAME }}"
   data-property_id="{{ $item->PROPERTY_ID }}"
   data-property_name="{{ $item->PROPERTY_NAME }}"
   data-due_id="{{ $item->DUE_ID }}"
   data-due_month="{{ $item->DUE_MONTH }}"
   data-due_year="{{ $item->DUE_YEAR }}"
   data-due_amount="{{ $item->DUE_AMOUNT }}"
   data-invoice_amount_with_vat="{{ $item->INVOICE_AMOUNT_WITH_VAT }}"
   data-total_amount="{{ $item->TOTAL_AMOUNT }}"
   data-vat_percentage="{{ $item->VAT_PERCENTAGE }}"
   data-vat_amount="{{ $item->VAT_AMOUNT }}"
   data-with_holding_percentage="{{ $item->WITH_HOLDING_PERCENTAGE }}"
   data-total_income_after_withholding_tax="{{ $item->TOTAL_INCOME_AFTER_WITH_HOLDING_TAX }}"
   data-payment_type="{{ $item->PAYMENT_TYPE }}"
   data-remarks="{{ $item->REMARKS }}"
   data-status_master="{{ $item->STATUS_MASTER }}"
   data-agreement_id="{{ $item->AGREEMENT_ID }}"
   data-bs-toggle="modal"
   data-bs-target="#viewAgreementMappingModal">
    <img src="assets/img/icons/eye.svg" alt="View">
</a>



<a class="me-3 edit-btn"
   href="javascript:void(0);"
   data-bs-toggle="modal"
   data-bs-target="#editAgreementModal"
   data-invoice_id="{{ $item->id }}"
   data-invoice_no="{{ $item->INVOICE_NO }}"
   data-invoice_date="{{ $item->INVOICE_DATE }}"
   data-payment_for="{{ $item->PAYMENT_FOR }}"
   data-tenant_id="{{ $item->TENANT_ID }}"
   data-branch_id="{{ $item->BRANCH_ID }}"
    data-building_id="{{ $item->BUILDING_ID }}"
   data-building_name="{{ $item->BUILDING_NAME }}"
   data-floor_id="{{ $item->FLOOR_ID }}"
   data-floor_name="{{ $item->FLOOR_NAME }}"
   data-property_id="{{ $item->PROPERTY_ID }}"
   data-property_name="{{ $item->PROPERTY_NAME }}"
   data-due_id="{{ $item->DUE_ID }}"
   data-due_month="{{ $item->DUE_MONTH }}"
   data-due_year="{{ $item->DUE_YEAR }}"
   data-due_amount="{{ $item->DUE_AMOUNT }}"
   data-invoice_amount_with_vat="{{ $item->INVOICE_AMOUNT_WITH_VAT }}"
   data-total_amount="{{ $item->TOTAL_AMOUNT }}"
   data-vat_percentage="{{ $item->VAT_PERCENTAGE }}"
   data-vat_amount="{{ $item->VAT_AMOUNT }}"
   data-with_holding_percentage="{{ $item->WITH_HOLDING_PERCENTAGE }}"
   data-total_income_after_withholding_tax="{{ $item->TOTAL_INCOME_AFTER_WITH_HOLDING_TAX }}"
   data-payment_type="{{ $item->PAYMENT_TYPE }}"
   data-remarks="{{ $item->REMARKS }}"
   data-status_master="{{ $item->STATUS_MASTER }}"
   data-agreement_id="{{ $item->AGREEMENT_ID }}"
>
    <img src="assets/img/icons/edit.svg" alt="Edit">
</a>




<a class="confirm-text delete-agreement-btn disabled"
   href="javascript:void(0);"
   data-invoice_id="{{ $item->id }}"
   data-invoice_no="{{ $item->INVOICE_NO }}"
   data-bs-toggle="modal"
   data-bs-target="#deletebuldingModal"
   tabindex="-1"
   aria-disabled="true"
   style="pointer-events: none; opacity: 0.5;">
    <img src="assets/img/icons/delete.svg" alt="Delete">
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






<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('invoice.save') }}">
                    @csrf
<div class="row">
                        <!-- First two fields in one row -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Invoice No</label>
                            <input type="text" class="form-control" name="invoice_no"  id="invoice_no" required readonly>
                        </div>

                                                <div class="col-md-6 mb-3">
                            <label class="form-label">Agreement ID</label>
                            <input type="text" class="form-control" name="agreement_id" id="agreement_id" readonly>
                        </div>

<div class="col-md-6 mb-3">
    <label class="form-label">Invoice Date</label>
    <input type="date" class="form-control" name="invoice_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
</div>

                                       
      <div class="col-md-6  mb-3">
                <label class="form-label">Tenant</label>
                <select class="form-select" name="tenant_id" id="tenant_id" required>
                    <option value="">Select Tenant </option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->TENANT_ID }}">{{ $tenant->TENANT_NAME }}</option>
                    @endforeach
                </select>
            </div>

            
                  <div class="col-md-6 mb-3">
                        <label class="form-label">Company</label>
                        <select class="form-select" name="company_id" id="company_id" required readonly>
                            <option value="">Select Company </option>
                            @foreach ($companies as $tenant)
                                <option value="{{ $tenant->COMPANY_ID }}">{{ $tenant->COMPANY_NAME }}</option>
                            @endforeach
                        </select>
                    </div>


            <div class="col-md-6  mb-3">
                <label class="form-label">Branch</label>
                <select class="form-select" name="branch_id" id="branch_id" required readonly>
                    <option value=""> Select Branch </option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->BRANCH_ID }}">{{ $branch->BRANCH_NAME }}</option>
                    @endforeach
                </select>
            </div>

                         

           <div class="col-md-6  mb-3">
    <label class="form-label">Building</label>
      <select class="form-select" name="building_id" id="building_id" required readonly>
         <option value="">Select Building </option>
         @foreach ($building as $branch)
                        <option value="{{ $branch->BUILDING_ID }}">{{ $branch->BUILDING_NAME }}</option>
                    @endforeach
    </select>
</div>

            <div class="col-md-6  mb-3">
                <label class="form-label">Floor</label>
                    <select class="form-select" name="floor_id" id="floor_id" required readonly>
        <option value="">Select Floor </option>
          @foreach ($floor as $branch)
                        <option value="{{ $branch->FLOOR_ID }}">{{ $branch->FLOOR_NAME }}</option>
                    @endforeach
    </select>
            </div>

               <div class="col-md-6  mb-3">
                <label class="form-label">Property</label>
                    <select class="form-select" name="property_id" id="property_id" required readonly>
        <option value="">Select Property</option>
            @foreach ($property as $branch)
                        <option value="{{ $branch->PROPERTY_ID }}">{{ $branch->PROPERTY_NAME }}</option>
                    @endforeach
    </select>
            </div>
                        
             <div class="col-md-6 mb-3">
                            <label class="form-label">Payment For</label>
                                <select class="form-select" name="payment_for" id="payment_for" required>
                                <option value="">Select Payment For</option>
                            </select>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label class="form-label">Due ID</label>
                            <input type="text" class="form-control" name="due_id" id="due_id" required readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Due Month</label>
                            <input type="text" class="form-control" name="due_month" id="due_month"  required readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Due Year</label>
                            <input type="number" class="form-control" name="due_year" id="due_year" required readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Due Amount</label>
                            <input type="number" class="form-control" name="due_amount" id="due_amount" step="0.01" required readonly>
                        </div>

                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Amount</label>
                            <input type="number" class="form-control" name="total_amount" id="total_amount" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Invoice Amount with VAT</label>
                            <input type="number" class="form-control" name="invoice_amount_with_vat" id="invoice_amount_with_vat" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">VAT %</label>
                            <input type="number" class="form-control" name="vat_percentage" id="vat_percentage" step="0.01" required >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">VAT Amount</label>
                            <input type="number" class="form-control" name="vat_amount" id="vat_amount" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Withholding %</label>
                            <input type="number" class="form-control" name="with_holding_percentage" id="with_holding_percentage"  step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Income After Withholding</label>
                            <input type="number" class="form-control" name="total_income_after_withholding_tax" id="total_income_after_withholding_tax" step="0.01" required > 
                       
                        </div>
    <div class="col-md-6 mb-3">
                            <label class="form-label">Payment Type</label>

                                                        <select class="form-select" name="payment_type" id="payment_type" required>
                                <option value="">Select Payment Type</option>

                            </select>
                        </div>

                    
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Remarks</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" maxlength="256">
                        </div>

                              <div class="col-md-6 mb-3">
                            <label for="status_master" class="form-label">Status</label>
                            <select class="form-select" id="status_master" name="status_master" required>
                            </select>
                        </div>


                    <!-- Hidden Metadata -->
                    <input type="hidden" name="created_by" value="{{ $createdBy }}">
                    <input type="hidden" name="created_mac_address" value="{{ $macAddress }}">

                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary">Save Invoice</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>


                </div>

                </form>
            
            </div>
        </div>
    </div>
</div>




<!-- Edit Agreement Modal -->
<div class="modal fade" id="editAgreementModal" tabindex="-1" aria-labelledby="editAgreementLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
       <div class="modal-body">
               

        <form method="POST" action="{{ route('invoice.update') }}">
                @csrf
                @method('POST')

                <div class="modal-body">
                    <input type="hidden" name="invoice_id" id="edit_invoice_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_invoice_no" class="form-label">Invoice No</label>
                            <input type="text" class="form-control" id="edit_invoice_no" name="invoice_no" required >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_invoice_date" class="form-label">Invoice Date</label>
                            <input type="date" class="form-control" id="edit_invoice_date" name="invoice_date" required>
                        </div>
                          
                                                <div class="col-md-6 mb-3">
                            <label class="form-label">Agreement ID</label>
                            <input type="text" class="form-control" name="agreement_id" id="edit_agreement_id" >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_payment_for" class="form-label">Payment For</label>
                            <select class="form-select" id="edit_payment_for" name="payment_for" required>
                                <option value="">Select Payment For</option>
                            </select>
                        </div>

                        
                    <!-- TENANT -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tenant</label>
                        <select class="form-select" name="tenant_id" id="edit_tenant_id" required >
                            <option value="">-- Select Tenant --</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->TENANT_ID }}">{{ $tenant->TENANT_NAME }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                  <div class="col-md-6 mb-3">
                        <label class="form-label">Company</label>
                        <select class="form-select" name="company_id" id="edit_company_id" required >
                            <option value="">Select Company </option>
                            @foreach ($companies as $tenant)
                                <option value="{{ $tenant->COMPANY_ID }}">{{ $tenant->COMPANY_NAME }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- BRANCH -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select class="form-select" name="branch_id" id="edit_branch_id" required >
                            <option value="">-- Select Branch --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->BRANCH_ID }}">{{ $branch->BRANCH_NAME }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BUILDING -->
                 

               <div class="col-md-6 mb-3">
    <label class="form-label">Building</label>
    <select class="form-select" name="building_id" id="edit_building_id" required >
        <option value="">-- Select Building --</option>
        @foreach ($building as $branch)
            <option value="{{ $branch->BUILDING_ID }}">{{ $branch->BUILDING_NAME }}</option>
        @endforeach
    </select>
</div>


<!-- FLOOR -->

     <div class="col-md-6  mb-3">
                <label class="form-label">Floor</label>
                    <select class="form-select" name="floor_id" id="edit_floor_id" required >
        <option value="">Select Floor</option>
          @foreach ($floor as $branch)
                        <option value="{{ $branch->FLOOR_ID }}">{{ $branch->FLOOR_NAME }}</option>
                    @endforeach
    </select>
            </div>

                

                    <!-- PROPERTY -->
          <div class="col-md-6  mb-3">
                <label class="form-label">Property</label>
                    <select class="form-select" name="property_id" id="edit_property_id" required >
        <option value=""> Select Property</option>
            @foreach ($property as $branch)
                        <option value="{{ $branch->PROPERTY_ID }}">{{ $branch->PROPERTY_NAME }}</option>
                    @endforeach
    </select>
            </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_due_id" class="form-label">Due ID</label>
                            <input type="text" class="form-control" id="edit_due_id" name="due_id" required >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_due_month" class="form-label">Due Month</label>
                            <input type="text" class="form-control" id="edit_due_month" name="due_month" required >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_due_year" class="form-label">Due Year</label>
                            <input type="number" class="form-control" id="edit_due_year" name="due_year" required >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_due_amount" class="form-label">Due Amount</label>
                            <input type="number" class="form-control" id="edit_due_amount" name="due_amount" step="0.01" required >
                        </div>

                                                <div class="col-md-6 mb-3">
                            <label for="edit_total_amount" class="form-label">Total Amount</label>
                            <input type="number" class="form-control" id="edit_total_amount" name="total_amount" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_invoice_amount_with_vat" class="form-label">Invoice Amount with VAT</label>
                            <input type="number" class="form-control" id="edit_invoice_amount_with_vat" name="invoice_amount_with_vat" step="0.01" required>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="edit_vat_percentage" class="form-label">VAT %</label>
                            <input type="number" class="form-control" id="edit_vat_percentage" name="vat_percentage" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_vat_amount" class="form-label">VAT Amount</label>
                            <input type="number" class="form-control" id="edit_vat_amount" name="vat_amount" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_with_holding_percentage" class="form-label">Withholding %</label>
                            <input type="number" class="form-control" id="edit_with_holding_percentage" name="with_holding_percentage" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_total_income_after_withholding_tax" class="form-label">Total Income After Withholding</label>
                            <input type="number" class="form-control" id="edit_total_income_after_withholding_tax" name="total_income_after_withholding_tax" step="0.01" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_payment_type" class="form-label">Payment Type</label>
                            <select class="form-select" id="edit_payment_type" name="payment_type" required>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_remarks" class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="edit_remarks" name="remarks" maxlength="256">
                        </div>

                      <div class="col-md-6 mb-3">
                            <label for="edit_status_master" class="form-label">Status</label>
                            <select class="form-select" id="edit_status_master" name="status_master" required>
                            </select>
                        </div>

                  

                        <input type="hidden" name="agreement_id" id="edit_agreement_id">
                    <input type="hidden" name="created_by" value="{{ $createdBy }}">
                    <input type="hidden" name="modified_by" value="{{ $createdBy }}">
                    <input type="hidden" name="created_mac_address" value="{{ $macAddress }}">
                    <input type="hidden" name="updated_mac_address" value="{{ $macAddress }}">
                    <input type="hidden" name="created_date" value="{{ now() }}">
                    <input type="hidden" name="modified_date" value="{{ now() }}">
                </div>

                <div class="modal-footer mt-3">
                    <button type="submit" class="btn btn-success">Update Invoice</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

                </div>
            </div>
           
        </div>
    </div>
</div>



<!-- View Invoice Modal -->
<div class="modal fade" id="viewAgreementMappingModal" tabindex="-1" aria-labelledby="viewAgreementMappingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewAgreementMappingModalLabel">Invoice Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <!-- Core Invoice Info -->
          <div class="col-md-6 mb-3"><label class="form-label">Invoice ID</label><input type="text" class="form-control" id="view_invoice_id" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Invoice No</label><input type="text" class="form-control" id="view_invoice_no" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Invoice Date</label><input type="text" class="form-control" id="view_invoice_date" readonly></div>
                     <div class="col-md-6 mb-3">
                            <label class="form-label">Agreement ID</label>
                            <input type="text" class="form-control" id="view_agreement_id" disabled>
                        </div>
          <div class="col-md-6 mb-3"><label class="form-label">Payment For</label><input type="text" class="form-control" id="view_payment_for" readonly></div>

          <!-- Location & Tenant -->
          <div class="col-md-6 mb-3"><label class="form-label">Tenant</label><input type="text" class="form-control" id="view_tenant_id" readonly></div>
          
          <div class="col-md-6 mb-3"><label class="form-label">Branch</label><input type="text" class="form-control" id="view_branch_id" readonly></div>
           <div class="col-md-6 mb-3">
          <label class="form-label">Company</label>
          <input type="text" class="form-control" id="view_company_id" readonly>
        </div>
          <div class="col-md-6 mb-3"><label class="form-label">Building</label><input type="text" class="form-control" id="view_building_id" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Floor</label><input type="text" class="form-control" id="view_floor_id" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Property</label><input type="text" class="form-control" id="view_property_id" readonly></div>

          <!-- Financials -->
          <div class="col-md-6 mb-3"><label class="form-label">Due ID</label><input type="text" class="form-control" id="view_due_id" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Due Month</label><input type="text" class="form-control" id="view_due_month" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Due Year</label><input type="text" class="form-control" id="view_due_year" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Due Amount</label><input type="text" class="form-control" id="view_due_amount" readonly></div>

          <div class="col-md-6 mb-3"><label class="form-label">Invoice Amount with VAT</label><input type="text" class="form-control" id="view_invoice_amount_with_vat" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Total Amount</label><input type="text" class="form-control" id="view_total_amount" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">VAT Percentage</label><input type="text" class="form-control" id="view_vat_percentage" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">VAT Amount</label><input type="text" class="form-control" id="view_vat_amount" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Withholding Percentage</label><input type="text" class="form-control" id="view_with_holding_percentage" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Total Income After Withholding</label><input type="text" class="form-control" id="view_total_income_after_withholding_tax" readonly></div>

          <!-- Other Info -->
          <div class="col-md-6 mb-3"><label class="form-label">Payment Type</label><input type="text" class="form-control" id="view_payment_type" readonly></div>
          <div class="col-md-6 mb-3"><label class="form-label">Status</label><input type="text" class="form-control" id="view_status_master" readonly></div>
         <!--  <div class="col-12 mb-3"><label class="form-label">Remarks</label><textarea class="form-control" id="view_remarks" rows="2" readonly></textarea></div>
-->
          <div class="mb-3 mt-4" id="detailsListContainer" >
                </div>
 
          <!-- Agreement Linkage
          <div class="col-md-6 mb-3"><label class="form-label">Agreement ID</label><input type="text" class="form-control" id="view_agreement_id_ref" readonly></div>
         -->
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Invoice Modal -->
<div class="modal fade" id="deletebuldingModal" tabindex="-1" aria-labelledby="deletebuldingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('invoice.delete') }}">
            @csrf
            <input type="hidden" name="id" id="delete_Agreement_Mapping_id">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deletebuldingModalLabel">Confirm Invoice Deletion</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete <strong id="delete_Agreement_Mapping_name">Invoice</strong> from the system?</p>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tenantIds = ['tenant_id', 'edit_tenant_id'];

    tenantIds.forEach(tenantFieldId => {
        const tenantField = document.getElementById(tenantFieldId);

        if (tenantField) {
            tenantField.addEventListener('change', function () {
                const tenantId = tenantField.value;

                // Determine prefix (edit_ or blank)
                const prefix = tenantFieldId.startsWith('edit') ? 'edit_' : '';

                if (tenantId) {
                    fetch(`/get-tenant-details?tenant_id=${tenantId}`, {
                        method: 'GET',
                        headers: { 'Accept': 'application/json' }
                    })
                    .then(response => response.json())
                    .then(result => {
                        const mapping = result.data?.[0] || {};

                        // Helper to set field value
                        const setFieldValue = (name, value = '') => {
                            const field = document.getElementById(`${prefix}${name}`);
                            if (field) field.value = value;
                        };

                        setFieldValue('agreement_id', mapping.AGREEMENT_ID);
                        setFieldValue('building_id', mapping.BUILDING_ID);
                        setFieldValue('floor_id', mapping.FLOOR_ID);
                        setFieldValue('property_id', mapping.PROPERTY_ID);
                        setFieldValue('branch_id', mapping.BRANCH_ID);
                        setFieldValue('status_master', mapping.STATUS_MASTER);
                        setFieldValue('due_id', mapping.DUE_ID);
                        setFieldValue('due_month', mapping.DUE_MONTH);
                        setFieldValue('due_year', mapping.DUE_YEAR);
                        setFieldValue('due_amount', mapping.RENTAL_AMOUNT);
                        setFieldValue('invoice_amount_with_vat', mapping.FINAL_RENT_AMOUNT_WITH_VAT);
                        setFieldValue('total_amount', mapping.TOTAL_RENT_AMOUNT);
                        setFieldValue('vat_percentage', parseFloat(mapping.VAT_PERCENTAGE || 0).toFixed(2));
                        setFieldValue('vat_amount', mapping.VAT_RENT_AMOUNT);
                        setFieldValue('with_holding_percentage', mapping.WITH_HOLDING_TAX_PERCENTAGE);
                        setFieldValue('total_income_after_withholding_tax', mapping.RENTAL_AMOUNT);
                        setFieldValue('remarks', mapping.REMARKS);
                    })
                    .catch(error => {
                        console.error("Error fetching tenant details:", error);
                        resetFields(prefix);
                    });
                } else {
                    // Reset fields if tenant is not selected
                    resetFields(prefix);
                }
            });
        }
    });

    // Reset function
    function resetFields(prefix) {
        const fields = [
            'agreement_id', 'building_id', 'floor_id', 'property_id', 'branch_id',
            'status_master', 'due_id', 'due_month', 'due_year', 'due_amount',
            'invoice_amount_with_vat', 'total_amount', 'vat_percentage', 'vat_amount',
            'with_holding_percentage', 'total_income_after_withholding_tax', 'remarks'
        ];
        fields.forEach(field => {
            const el = document.getElementById(`${prefix}${field}`);
            if (el) el.value = '';
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const branchSelect  = document.getElementById('branch_id');
    const tenantSelect  = document.getElementById('tenant_id');
    const propertyInput = document.getElementById('property_id');

    if (tenantSelect) {
        tenantSelect.addEventListener('change', function () {
            const tenantId   = tenantSelect?.value;
            const propertyId = propertyInput?.value;

            if (tenantId && propertyId) {
                fetch(`/agreement-id/${tenantId}/${propertyId}`, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server responded with ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Agreement ID data received:", data);
                })
                .catch(error => {
                    console.error("Error fetching agreement ID:", error);
                });
            } else {
                console.warn("Missing tenant or property ID, cannot fetch agreement ID.");
            }
        });
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentForSelect = document.getElementById('payment_for');

    if (!paymentForSelect) return;

    paymentForSelect.addEventListener('change', function () {
        const paymentFor = this.value;

        const branchId   = document.getElementById('branch_id')?.value;
        const tenantId   = document.getElementById('tenant_id')?.value;
        const buildingId = document.getElementById('building_id')?.value;
        const floorId    = document.getElementById('floor_id')?.value;
        const propertyId = document.getElementById('property_id')?.value;

        console.log('🔎 Selected:', { paymentFor, branchId, tenantId, buildingId, floorId, propertyId });

        if (paymentFor && branchId && tenantId && buildingId && floorId && propertyId) {
            fetch("{{ route('due.details') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_for: paymentFor,
                    branch_id: branchId,
                    tenant_id: tenantId,
                    building_id: buildingId,
                    floor_id: floorId,
                    property_id: propertyId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('📥 Response data:', data);

                if (Array.isArray(data) && data.length > 0) {
                    const due = data[0];

                    // Populate basic fields
                    document.querySelector('input[name="due_month"]').value = due.DUE_MONTH || '';
                    document.querySelector('input[name="due_year"]').value = due.DUE_YEAR || '';
                  document.querySelector('input[name="due_amount"]').value = due["DUE AMOUNT"] || '';

                    document.querySelector('input[name="due_id"]').value = due.DUE_ID || '';
                    document.querySelector('input[name="invoice_amount_with_vat"]').value = due.FINAL_PAYABLE_AMOUNT_WITH_VAT || '';
                    document.querySelector('input[name="vat_amount"]').value = due.Vat_Amount || '';

                    // Populate extended financials
                    document.querySelector('input[name="total_amount"]').value = due["Total amount"] || '';
                    document.querySelector('input[name="vat_percentage"]').value = due["VAT %"] || '';
                    document.querySelector('input[name="with_holding_percentage"]').value = due["WITH_HOLDING_TAX_PERCENTAGE"] || '';
                    document.querySelector('input[name="total_income_after_withholding_tax"]').value = due["TOTAL_INCOME_AFTER_WITH_HOLDING_TAX"] || '';

                    // Update the due ID select input if needed
                    const dueIdSelect = document.querySelector('select[name="due_id"]');
                    if (dueIdSelect && due.DUE_ID) {
                        dueIdSelect.innerHTML = '';
                        const option = new Option(`Due ${due.DUE_MONTH}/${due.DUE_YEAR}`, due.DUE_ID, true, true);
                        dueIdSelect.appendChild(option);
                    }
                } else {
                    console.warn('⚠️ No due details returned.');
                }
            })
            .catch(error => {
                console.error('file-pathFetch error:', error);
            });
        } else {
            console.warn('⚠️ Missing required fields — cannot fetch due details.');
        }
    });
});
</script>





<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Standard field mapping: data-key => input ID
            const fields = {
                invoice_id: 'edit_invoice_id',
                invoice_no: 'edit_invoice_no',
                invoice_date: 'edit_invoice_date',
                payment_for: 'edit_payment_for',
                tenant_id: 'edit_tenant_id',
                branch_id: 'edit_branch_id',
                building_id: 'edit_building_id',
                floor_id: 'edit_floor_id',
                property_id: 'edit_property_id',
                due_id: 'edit_due_id',
                due_month: 'edit_due_month',
                due_year: 'edit_due_year',
                due_amount: 'edit_due_amount',
                invoice_amount_with_vat: 'edit_invoice_amount_with_vat',
                total_amount: 'edit_total_amount',
                vat_percentage: 'edit_vat_percentage',
                vat_amount: 'edit_vat_amount',
                with_holding_percentage: 'edit_with_holding_percentage',
                total_income_after_withholding_tax: 'edit_total_income_after_withholding_tax',
                payment_type: 'edit_payment_type',
                remarks: 'edit_remarks',
                status_master: 'edit_status_master',
                agreement_id: 'edit_agreement_id'
            };

            // Populate standard fields
            Object.entries(fields).forEach(([dataKey, inputId]) => {
                const value = button.getAttribute(`data-${dataKey}`);
                if (inputId && value !== null) {
                    const inputField = document.getElementById(inputId);
                    if (inputField) inputField.value = value;
                }
            });

            // Populate display-only name fields
            const displayFields = {
                building_name: 'edit_building_name',
                floor_name: 'edit_floor_name',
                property_name: 'edit_property_name'
            };

            Object.entries(displayFields).forEach(([dataKey, inputId]) => {
                const value = button.getAttribute(`data-${dataKey}`);
                if (value !== null) {
                    const displayField = document.getElementById(inputId);
                    if (displayField) displayField.value = value;
                }
            });

            // Debugging log
            console.log("✅ Edit modal data loaded:", {
                invoice_id: button.getAttribute('data-invoice_id'),
                invoice_no: button.getAttribute('data-invoice_no'),
                building_name: button.getAttribute('data-building_name'),
                floor_name: button.getAttribute('data-floor_name'),
                property_name: button.getAttribute('data-property_name')
                // Add more keys if needed
            });
        });
    });
});
</script>


<script>
   document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-agreement-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const AgreementId = this.dataset.id;
            const AgreementName = this.dataset.name;

            document.getElementById('delete_Agreement_Mapping_id').value = AgreementId;
            document.getElementById('delete_Agreement_Mapping_name').textContent = AgreementName;
        });
    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
   
  const viewButtons = document.querySelectorAll('.view-btn');

  viewButtons.forEach(button => {
    button.addEventListener('click', function () {
         const data = this.dataset;
         console.log('id clicked is',data.invoice_id)
         LoadDetails(data.invoice_id);

    document.getElementById('view_tenant_id').value = data.tenant_id || '';
    document.getElementById('view_branch_id').value = data.branch_id || '';
      document.getElementById('view_building_id').value = data.building_name || '';
      document.getElementById('view_floor_id').value = data.floor_name || '';
      document.getElementById('view_property_id').value = data.property_name || '';

      const fields = {
        invoice_id: 'view_invoice_id',
        invoice_no: 'view_invoice_no',
        invoice_date: 'view_invoice_date',
        payment_for: 'view_payment_for',
       // tenant_id: 'view_tenant_id',
       // branch_id: 'view_branch_id',
       // building_id: 'view_building_id',
       // building_name: 'view_building_name', 
      //  floor_id: 'view_floor_id',
      //  floor_name: 'view_floor_name',
      //  property_id: 'view_property_id',
      //  property_name: 'view_property_name',
        due_id: 'view_due_id',
        due_month: 'view_due_month',
        due_year: 'view_due_year',
        due_amount: 'view_due_amount',
        invoice_amount_with_vat: 'view_invoice_amount_with_vat',
        total_amount: 'view_total_amount',
        vat_percentage: 'view_vat_percentage',
        vat_amount: 'view_vat_amount',
        with_holding_percentage: 'view_with_holding_percentage',
        total_income_after_withholding_tax: 'view_total_income_after_withholding_tax',
        payment_type: 'view_payment_type',
        remarks: 'view_remarks',
        status_master: 'view_status_master',
        agreement_id: 'view_agreement_id'
      };

    
      Object.entries(fields).forEach(([dataKey, fieldId]) => {
        const value = button.getAttribute(`data-${dataKey}`);
        const input = document.getElementById(fieldId);
        if (input) {
          input.tagName === 'TEXTAREA'
            ? input.textContent = value ?? ''
            : input.value = value ?? '';
        }
      });

     
      function LoadDetails(data) {
    fetch(`/LoadInvoiceDetails/${data}`)
        .then(response => response.json())
        .then(data => {
            console.log('Parsed document data:', data);

            const detailsListContainer = document.getElementById('detailsListContainer');
            detailsListContainer.innerHTML = ''; // Clear previous content

            if (Array.isArray(data) && data.length > 0) {
                // Start building the table
                let tableHTML = `
                <h3>Invoice Due Details</h3>
                    <table class="table table-bordered table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                  <th>Due ID</th>
                                    <th>Due Month</th>
                                      <th>Due Year</th>
                                        <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                data.forEach(doc => {
                    const invoiceID = doc.INVOICE_ID || 'N/A';
                    const dueID = doc.DUE_ID || 'N/A';
                    const dueAmount = doc.DUE_MONTH || 'N/A';
                    const dueYear = doc.DUE_YEAR || 'N/A';
                    const amount = doc.AMOUNT || 'N/A';

                    tableHTML += `
                        <tr>
                            <td>${invoiceID}</td>
                            <td>${dueID}</td>
                            <td>${dueAmount}</td>
                            <td>${dueYear}</td>
                            <td>${amount}</td>
                        </tr>
                    `;
                });

                tableHTML += `
                        </tbody>
                    </table>
                `;

                detailsListContainer.innerHTML = tableHTML;
            } else {
                detailsListContainer.innerHTML = `<span class="text-muted fst-italic">No Details available</span>`;
            }
        })
        .catch(err => console.error('Error loading documents:', err));
}


      console.log("🔎 View modal populated:", {
        invoice_no: button.getAttribute('data-invoice_no'),
        invoice_date: button.getAttribute('data-invoice_date'),
        tenant_id: button.getAttribute('data-tenant_id')
        // Add more fields if needed
      });
    });
  });
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    var documentModal = document.getElementById('documentModal');

    if (!documentModal) {
        console.error('Modal element #documentModal not found!');
        return;
    }

    documentModal.addEventListener('shown.bs.modal', function () {
        console.log('Document Modal is opened');

        const tenantSelect = documentModal.querySelector('#tenant_id');
        const agreementSelect = documentModal.querySelector('#agreement_id');

        if (!tenantSelect) {
            console.error('Tenant select #tenant_id not found in modal!');
            return;
        }
        if (!agreementSelect) {
            console.error('Agreement select #agreement_id not found in modal!');
            return;
        }

        // Clear agreement dropdown every time modal opens
        agreementSelect.innerHTML = '<option value="">-- Select Agreement --</option>';

        // Remove existing change listener by cloning the node (clean slate)
        const newTenantSelect = tenantSelect.cloneNode(true);
        tenantSelect.parentNode.replaceChild(newTenantSelect, tenantSelect);

        console.log('Attaching change event listener to tenant select');

        newTenantSelect.addEventListener('change', function () {
            const tenantId = this.value;
            console.log('Tenant selected:', tenantId);

            if (tenantId) {
                fetch(`/agreements-by-tenant/${tenantId}`)
                    .then(response => {
                        console.log('Raw fetch response:', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Parsed agreements data:', data);

                        agreementSelect.innerHTML = '<option value="">-- Select Agreement --</option>';

                        if (!data || data.length === 0) {
                            console.log('No agreements found for this tenant.');
                            agreementSelect.innerHTML = '<option value="">-- No agreements found --</option>';
                        } else {
                            data.forEach(agreement => {
                                console.log('Adding agreement option:', agreement);
                                const option = document.createElement('option');
                                option.value = agreement.AGREEMENT_ID;
                                option.text = agreement.AGREEMENT_NAME || `Agreement #${agreement.AGREEMENT_ID}`;
                                agreementSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        agreementSelect.innerHTML = '<option value="">-- Error loading --</option>';
                    });
            } else {
                console.log('No tenant selected, clearing agreement dropdown.');
                agreementSelect.innerHTML = '<option value="">-- Select Agreement --</option>';
            }
        });

        // For debugging: show attached event listeners in console
        console.log('Event listeners on tenant select:', getEventListeners(newTenantSelect));
    });
});




</script>


</body>
</html>