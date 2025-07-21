
document.addEventListener('DOMContentLoaded', function () {
  function setupDynamicUpdater({
    baseId,                  
    inputIds = [],
    endpointUrlBuilder,
    targetBaseId,     
    populateResponse,
    placeholder = 'Select Option',
    method = 'GET',
    headers = { 'Accept': 'application/json' }
  }) {
    const modes = ['', 'edit_']; 

    modes.forEach(prefix => {
      const triggerId = prefix + baseId;
      const targetId = prefix + targetBaseId;

      const triggerEl = document.getElementById(triggerId);
      const targetEl = document.getElementById(targetId);

      if (!triggerEl || !targetEl) return;

      triggerEl.addEventListener('change', function () {
        const inputs = {};
        inputIds.forEach(id => {
          const el = document.getElementById(prefix + id);
          inputs[prefix + id] = el ? el.value : null;
        });

        const url = endpointUrlBuilder(inputs);
        if (!url) return;

        if (targetEl.tagName === 'SELECT') {
          targetEl.innerHTML = `<option value="">${placeholder}</option>`;
        } else if (targetEl.tagName === 'INPUT' || targetEl.tagName === 'TEXTAREA') {
          targetEl.value = '';
        }

        fetch(url, { method, headers })
          .then(res => {
            if (!res.ok) throw new Error(`Server error: ${res.status}`);
            return res.json();
          })
          .then(data => {
            populateResponse(data, targetEl);
          })
          .catch(err => {
            console.error('error when fetching data:', err);
          });
      });
    });
  }

  //ENDS OF FUNCTION


  //CALLING

  //Loading Tenant based on company selected
  setupDynamicUpdater({
    baseId: 'company_id',
    inputIds: ['company_id'],
    targetBaseId: 'tenant_id',
    endpointUrlBuilder: (inputs) => {
      const key = Object.keys(inputs).find(k => inputs[k]);
      return key ? `/load-tenant-by-company?company_id=${encodeURIComponent(inputs[key])}` : null;
    },
    populateResponse: (data, targetEl) => {
      const items = data.data || [];
      items.forEach(item => {
        if (item.TENANT_ID && item.TENANT_NAME) {
          const option = document.createElement('option');
          option.value = item.TENANT_ID;
          option.textContent = item.TENANT_NAME;
          targetEl.appendChild(option);
        }
      });
    },
    placeholder: 'Select Tenant11111'
  });


  //loading Branches  based on company selected

  setupDynamicUpdater({
  baseId: 'company_id',
  inputIds: ['company_id'],
  targetBaseId: 'branch_id',
  endpointUrlBuilder: (inputs) => {
    const companyKey = Object.keys(inputs).find(k => k.endsWith('company_id'));
    const companyId = inputs[companyKey];

    return companyId
      ? `/load-branch-by-company?company_id=${encodeURIComponent(companyId)}`
      : null;
  },
  populateResponse: (data, targetEl) => {
    const items = data.data || [];
    items.forEach(branch => {
      if (branch.BRANCH_ID && branch.BRANCH_NAME) {
        const option = document.createElement('option');
        option.value = branch.BRANCH_ID;
        option.textContent = branch.BRANCH_NAME;
        targetEl.appendChild(option);
      }
    });
  },
  placeholder: 'Select Branch11'
});

  //loading buildings based on branch

  setupDynamicUpdater({
  baseId: 'branch_id',
  inputIds: ['branch_id'],
  targetBaseId: 'building_id',
  endpointUrlBuilder: (inputs) => {
    const branchKey = Object.keys(inputs).find(k => k.endsWith('branch_id'));
    const branchId = inputs[branchKey];

    return branchId
      ? `/load-buildings-by-branch?branch_id=${encodeURIComponent(branchId)}`
      : null;
  },
  populateResponse: (data, targetEl) => {
    const items = data.data || [];
    items.forEach(building => {
      if (building.BUILDING_ID && building.BUILDING_NAME) {
        const option = document.createElement('option');
        option.value = building.BUILDING_ID;
        option.textContent = building.BUILDING_NAME;
        targetEl.appendChild(option);
      }
    });
  },
  placeholder: 'Select Building111'
});


//loading floor based on building selected

  setupDynamicUpdater({
  baseId: 'building_id',                       
  inputIds: ['branch_id', 'building_id'],      
  targetBaseId: 'floor_id',                  
  endpointUrlBuilder: (inputs) => {
    const branchKey = Object.keys(inputs).find(k => k.endsWith('branch_id'));
    const buildingKey = Object.keys(inputs).find(k => k.endsWith('building_id'));

    const branchId = inputs[branchKey];
    const buildingId = inputs[buildingKey];

    return branchId && buildingId
      ? `/load-floors?branch_id=${encodeURIComponent(branchId)}&building_id=${encodeURIComponent(buildingId)}`
      : null;
  },
  populateResponse: (data, targetEl) => {
    const items = data.data || [];
    items.forEach(floor => {
      if (floor.FLOOR_ID && floor.FLOOR_NAME) {
        const option = document.createElement('option');
        option.value = floor.FLOOR_ID;
        option.textContent = floor.FLOOR_NAME;
        targetEl.appendChild(option);
      }
    });
  },
  placeholder: 'Select Floor1111'
});

//loading Property based on floor  selected

setupDynamicUpdater({
  baseId: 'floor_id',
  inputIds: ['branch_id', 'building_id', 'floor_id'],
  targetBaseId: 'property_id',
  endpointUrlBuilder: (inputs) => {
    const branchKey = Object.keys(inputs).find(k => k.endsWith('branch_id'));
    const buildingKey = Object.keys(inputs).find(k => k.endsWith('building_id'));
    const floorKey = Object.keys(inputs).find(k => k.endsWith('floor_id'));

    const branchId = inputs[branchKey];
    const buildingId = inputs[buildingKey];
    const floorId = inputs[floorKey];

    return branchId && buildingId && floorId
      ? `/load-property?branch_id=${encodeURIComponent(branchId)}&building_id=${encodeURIComponent(buildingId)}&floor_id=${encodeURIComponent(floorId)}`
      : null;
  },
  populateResponse: (data, targetEl) => {
    const items = data.data || [];
    items.forEach(property => {
      if (property.PROPERTY_ID && property.PROPERTY_NAME) {
        const option = document.createElement('option');
        option.value = property.PROPERTY_ID;
        option.textContent = property.PROPERTY_NAME;
        targetEl.appendChild(option);
      }
    });
  },
  placeholder: 'Select Property111'
});

///loads propery based on the floor selected

setupDynamicUpdater({
  baseId: 'floor_id',
  inputIds: ['branch_id', 'building_id', 'floor_id'],
  targetBaseId: 'property_id',
  endpointUrlBuilder: (inputs) => {
    const branchKey = Object.keys(inputs).find(k => k.endsWith('branch_id'));
    const buildingKey = Object.keys(inputs).find(k => k.endsWith('building_id'));
    const floorKey = Object.keys(inputs).find(k => k.endsWith('floor_id'));

    const branchId = inputs[branchKey];
    const buildingId = inputs[buildingKey];
    const floorId = inputs[floorKey];

    return branchId && buildingId && floorId
      ? `/load-property?branch_id=${encodeURIComponent(branchId)}&building_id=${encodeURIComponent(buildingId)}&floor_id=${encodeURIComponent(floorId)}`
      : null;
  },
  populateResponse: (data, targetEl) => {
    const items = data.data || [];
    items.forEach(property => {
      if (property.PROPERTY_ID && property.PROPERTY_NAME) {
        const option = document.createElement('option');
        option.value = property.PROPERTY_ID;
        option.textContent = property.PROPERTY_NAME;
        targetEl.appendChild(option);
      }
    });
  },
  placeholder: 'Select Property111'
});


//ENDS OF CALLING


//ANOTHER FUNCTION
//common dropdown data loading function
function loadCommonDropdown(fieldId, $select, selectedValue = '') {

  $.ajax({
     url: '/common-dropdown/' + fieldId,
    method: 'GET',
    success: function (response) {
        populateDropdown($select, response, 'ACTIVITY_NAME', 'ACTIVITY_NAME', selectedValue);
    },
    error: function (xhr, status, error) {
      console.error('AJAX error loading common dropdown:', error);
    }
  });
}

function populateDropdown($select, data, idField, nameField, selectedValue = '') {
  $select.empty();
  $select.append('<option value="">-- Select --</option>');

  if (data && data.length > 0) {
    data.forEach(item => {
      const isSelected = item[idField] == selectedValue ? 'selected' : '';
      $select.append(`<option value="${item[idField]}" ${isSelected}>${item[nameField]}</option>`);
    });
  }
}

//ENDS OF SECONDS FUNCTIONS BLOCK

//CALLING OF FUNCTIONS
loadCommonDropdown(1, $('#status_master'),'ACTIVE');
loadCommonDropdown(1, $('#edit_status_master'),'ACTIVE');
loadCommonDropdown(1, $('#doc_status_master'),'ACTIVE');
loadCommonDropdown(2, $('#agreement_type'));
loadCommonDropdown(2, $('#edit_agreement_type'));
loadCommonDropdown(3, $('#notice_period_status'),'NO');
loadCommonDropdown(3, $('#edit_notice_period_status'),'NO');
loadCommonDropdown(4, $('#payment_for'));
loadCommonDropdown(4, $('#edit_payment_for'));
loadCommonDropdown(5, $('#payment_type'));
loadCommonDropdown(5, $('#edit_payment_type'));

//ENDS OF CALLING FUNCTIONS 

//from to date calculations 
function setupNoticePeriodCalculatorOnce() {
  const modes = ['', 'edit_'];

  modes.forEach(mode => {
    const fromId = mode + 'agreement_from_date';
    const toId = mode + 'agreement_to_date';
    const targetId = mode + 'notice_period_days';

    const fromInput = document.getElementById(fromId);
    const toInput = document.getElementById(toId);
    const targetInput = document.getElementById(targetId);

    if (!fromInput || !toInput || !targetInput) return;

    function calculateDays() {
      const fromDate = new Date(fromInput.value);
      const toDate = new Date(toInput.value);

      if (!isNaN(fromDate) && !isNaN(toDate)) {
        const timeDiff = toDate - fromDate;
        const daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
        targetInput.value = daysDiff >= 0 ? daysDiff : '';
      } else {
        targetInput.value = '';
      }
    }

    fromInput.addEventListener('change', calculateDays);
    toInput.addEventListener('change', calculateDays);
  });
}


setupNoticePeriodCalculatorOnce()

//ends

//when price id changes or price id as trigger
function setupPriceAutoPopulate() {
  const priceSelects = document.querySelectorAll('select[name="price_id"]');

  priceSelects.forEach(priceSelect => {
    priceSelect.addEventListener('change', function () {
      const priceId = this.value;
      if (!priceId) return;

      const url = `/price-details/${priceId}`;
      const form = this.closest('form'); // scope to the current form

      fetch(url)
        .then(response => {
          if (!response.ok) throw new Error(`Server error: ${response.status}`);
          return response.json();
        })
        .then(data => {
            const priceData = data[0] || {};
          const setValueByName = (name, value) => {
            const input = form.querySelector(`[name="${name}"]`);
            if (input) input.value = value;
          };


          console.log(priceData)

          // Reset deposit-related fields
          setValueByName('deposit_amount', "0");
          setValueByName('vat_deposit_amount', "0");
          setValueByName('final_deposit_amount_with_vat', "0");

          // Populate data  
          setValueByName('common_maintenance_amount', priceData.COMMON_MAINTENANCE_AMOUNT || "");
          setValueByName('rental_amount', priceData.TOTAL_RENT_AMOUNT_WITHOUT_VAT || "");
          setValueByName('total_rent_amount', priceData.RENTAL_AMOUNT || "");
          setValueByName('vat_rent_amount', priceData.VAT_RENT_AMOUNT || "");
          setValueByName('final_rent_amount_with_vat', priceData.FINAL_RENT_AMOUNT_WITH_VAT || "");
          setValueByName('renewal_percentage', priceData.RENEWAL_PERCENTAGE || "");

          // Percentages
          setValueByName('vat_percentage',
            isNaN(parseFloat(priceData.VAT_PERCENTAGE)) ? "" : parseFloat(priceData.VAT_PERCENTAGE).toFixed(2)
          );
          setValueByName('With_holding_vat_percentage',
            isNaN(parseFloat(priceData.WITH_HOLDING_PERCENTAGE)) ? "" : parseFloat(priceData.WITH_HOLDING_PERCENTAGE).toFixed(2)
          );
        })
        .catch(error => {
          console.error('Error fetching price data:', error);
        });
    });
  });
}

setupPriceAutoPopulate();


//load price id based on rental type and propery id 
setupDynamicUpdater({
  baseId: 'rental_type_id',
  inputIds: ['rental_type_id', 'property_id'],
  targetBaseId: 'price_id',
  endpointUrlBuilder: (inputs) => {
    const rentalTypeKey = Object.keys(inputs).find(k => k.endsWith('rental_type_id'));
    const propertyKey = Object.keys(inputs).find(k => k.endsWith('property_id'));

    const rentalTypeId = inputs[rentalTypeKey];
    const propertyId = inputs[propertyKey];

    return rentalTypeId && propertyId
      ? `/load-price_id?rental_type_id=${encodeURIComponent(rentalTypeId)}&property_id=${encodeURIComponent(propertyId)}`
      : null;
  },
 populateResponse: (data, targetEl) => {
  const properties = data.data || [];

  targetEl.innerHTML = '';

  properties.forEach(item => {
    const option = document.createElement('option');
    option.value = item.PRICE_ID;
    option.textContent = item.RENTAL_AMOUNT;
    targetEl.appendChild(option);
  });
  if (!targetEl.value && properties.length > 0) {
    targetEl.value = properties[0].PRICE_ID;
  }
  targetEl.dispatchEvent(new Event('change'));
},

  placeholder: ''
});

 

//view and edit btn-handle


// Generic function to populate modal from data attributes
function populateModal(triggerElement, fieldMappings, isEdit = false) {
    for (const [dataAttr, fieldId] of Object.entries(fieldMappings)) {
        const value = triggerElement.getAttribute(`data-${dataAttr}`);
        const field = document.getElementById(fieldId);
        
        if (!field) continue;
        
        // Special handling for different field types
        if (field.tagName === 'SELECT') {
            // Find matching option
            const option = Array.from(field.options).find(
                opt => opt.value === value
            );
            if (option) option.selected = true;
        } 
        else if (field.type === 'date' && value) {
            field.value = value.split(' ')[0]; // Trim time portion
        } 
        else {
            field.value = value || '';
        }
    }

    // Special cases for edit modal
    if (isEdit) {
        // Show/hide renewal percentage field
        const agreementType = document.getElementById(fieldMappings['agreementType']);
        const renewalContainer = document.getElementById('edit_renewalPercentageContainer');
        if (agreementType && renewalContainer) {
            renewalContainer.style.display = 
                agreementType.value.toUpperCase() === 'RENEWAL' ? 'block' : 'none';
        }
    }
}

// Edit Modal Configuration
const editFieldMappings = {
    'id': 'edit_agreement_id',
      'oldId': 'edit_old_agreement_id',
    'agreementType': 'edit_agreement_type',
    'tenant': 'edit_tenant_id',
    'companyid': 'edit_company_id',
    'branch': 'edit_branch_id',
    'building': 'edit_building_id',
    'floor': 'edit_floor_id',
    'property': 'edit_property_id',
    'rental': 'edit_rental_amount',
    'final-rent': 'edit_final_rent_amount_with_vat',
    'from': 'edit_agreement_from_date',
    'to': 'edit_agreement_to_date',
    'remarks': 'edit_remarks',
    'status': 'edit_status_master',
    'price': 'edit_price_id',
    'renewal': 'edit_renewal_percentage',
    'deposit': 'edit_deposit_amount',
    'vat-deposit': 'edit_vat_deposit_amount',
    'final-deposit': 'edit_deposit_amount_with_vat',
    'maintenance': 'edit_common_maintenance_amount',
    'total-rent': 'edit_total_rent_amount',
    'vat-rent': 'edit_vat_rent_amount',
    'notice-days': 'edit_notice_period_days',
    'notice-status': 'edit_notice_period_status',
    'rental-type': 'edit_rental_type_id',
    'vat_percentage': 'edit_vat_percentage',
    'with_holding_tax_percentage': 'edit_With_holding_vat_percentage'
};

// View Modal Configuration
const viewFieldMappings = {
    'id': 'view_agreement_id',
    'oldId': 'edit_old_agreement_id',
    'agreementType': 'view_agreement_type',
    'tenant': 'view_tenant_id',
    'company': 'view_company_id',
    'branch': 'view_branch_id',
    'building': 'view_building_id',
    'floor': 'view_floor_id',
    'property': 'view_property_id',
    'rental-type-id': 'view_rental_type_id',
    'from': 'view_agreement_from_date',
    'to': 'view_agreement_to_date',
    'notice-days': 'view_notice_period_days',
    'notice-status': 'view_notice_period_status',
    'renewal': 'view_renewal_percentage',
    'deposit': 'view_deposit_amount',
    'vat-deposit': 'view_vat_deposit_amount',
    'final-deposit': 'view_final_deposit_amount_with_vat',
    'rental': 'view_rental_amount',
    'maintenance': 'view_common_maintenance_amount',
    'total-rent': 'view_total_rent_amount',
    'vat-rent': 'view_vat_rent_amount',
    'final-rent': 'view_final_rent_amount_with_vat',
    'remarks': 'view_remarks',
    'status': 'view_status_master'
};

// Document Loader Functions
function loadDocumentPath(agreementId) {
    fetch(`/LoadDocumentPath/${agreementId}`)
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('documentListContainer');
        container.innerHTML = '';

        if (data.length > 0) {
            container.innerHTML = `<h3 class="mb-3">Tenants Agreements Documents</h3>`;
            data.forEach(doc => {
                container.innerHTML += `
                    <div class="d-flex justify-content-between align-items-center bg-light border p-2 mb-2 rounded">
                        <span>${doc.DOCUMENT_NAME}</span>
                        <button class="btn btn-sm btn-outline-primary view-document-btn"
                                data-file-path="${doc.FILE_PATH}">
                            View Document
                        </button>
                    </div>
                `;
            });
        } else {
            container.innerHTML = `<p class="text-muted">No documents found</p>`;
        }
    });
}

document.getElementById('documentListContainer').addEventListener('click', function (e) {
    if (e.target.classList.contains('view-document-btn')) {
        const filePath = e.target.dataset.filePath;

        if (filePath) {
            // Open document in a new browser tab
            window.open(filePath, '_blank');
        } else {
            alert('Document path is missing.');
        }
    }
});

function loadDetails(agreementId) {
    fetch(`/LoadAgreementMappingDetails/${agreementId}`)
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('detailsListContainer');
        container.innerHTML = '';

        if (data.length > 0) {
            let tableHTML = `
                <h4>Tenant Agreement Mapping Details</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.forEach(item => {
                tableHTML += `
                    <tr>
                        <td>${item.DUE_MONTH || 'N/A'}</td>
                        <td>${item.DUE_YEAR || 'N/A'}</td>
                        <td>${item.DUE_DATE || 'N/A'}</td>
                        <td>${item.FINAL_PAYABLE_AMOUNT_WITH_VAT || '0.00'}</td>
                        <td>${item.PAID_AMOUNT || '0.00'}</td>
                        <td>${item.BALANCE_AMOUNT || '0.00'}</td>
                    </tr>
                `;
            });

            tableHTML += `</tbody></table>`;
            container.innerHTML = tableHTML;
        } else {
            container.innerHTML = `<p class="text-muted">No payment details available</p>`;
        }
    });
}

// Event Delegation Setup
document.addEventListener('click', function(e) {
    const editBtn = e.target.closest('.edit-btn');
    const viewBtn = e.target.closest('.view-btn');
    const deleteBtn = e.target.closest('.delete-agreement-btn');
    
    // Handle Edit Button
    if (editBtn) {
        populateModal(editBtn, editFieldMappings, true);
    }
    
    // Handle View Button
    if (viewBtn) {
        populateModal(viewBtn, viewFieldMappings);
        const agreementId = viewBtn.dataset.id;
        loadDocumentPath(agreementId);
        loadDetails(agreementId);
    }
    
    // Handle Delete Button
    if (deleteBtn) {
        document.getElementById('delete_Agreement_Mapping_id').value = deleteBtn.dataset.id;
        document.getElementById('delete_Agreement_Mapping_name').textContent = 
            deleteBtn.dataset.name || 'this agreement';
    }
});

// Document Preview Handler
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('view-document-btn')) {
        const filePath = e.target.dataset.filePath;
        document.getElementById('documentPreviewContent').innerHTML = `
            <iframe src="${filePath}" style="width:100%; height:80vh;" 
                    frameborder="0"></iframe>
        `;
    }
});



///showing renewal % when agreement type is renewal 

 // This sets up listeners on all agreement_type fields on page load


/**
 * Attach change listeners to all agreement_type fields.
 * Call this when new fields are added dynamically (e.g. after modal open).
 */
function setupAgreementTypeHandlers() {
    document.querySelectorAll('[id$="agreement_type"]').forEach(select => {
        toggleRenewalField(select); // Initial check

        // Avoid multiple listeners by removing then re-adding
        select.removeEventListener('change', handleAgreementChange);
        select.addEventListener('change', handleAgreementChange);
    });
}

// Reusable listener function
function handleAgreementChange(event) {
    toggleRenewalField(event.target);
}

/**
 * Show/hide the renewal percentage field based on agreement type value.
 * @param {HTMLSelectElement} selectElement 
 */
function toggleRenewalField(selectElement) {
    const selectedType = selectElement.value;
    const baseId = selectElement.id.replace('agreement_type', '');
    const renewalContainer = document.getElementById(`${baseId}renewalPercentageContainer`);

    if (!renewalContainer) return;

    if (selectedType === 'RENEWAL') {
        renewalContainer.style.display = 'block';
    } else {
        renewalContainer.style.display = 'none';
        const input = renewalContainer.querySelector('input');
        if (input) input.value = '';
    }
}


    setupAgreementTypeHandlers();

// Master event delegation handler
document.addEventListener('click', function(e) {
    const target = e.target;
    
    // Handle add-document-btn clicks
if (target.closest('.add-document-btn')) {
    const btn = target.closest('.add-document-btn');
    const agreementId = btn.dataset.id;
    const tenantId = btn.dataset.tenant;

    const tenantSelect = document.getElementById('view_tenant_id_for_document');
    const agreementSelect = document.getElementById('view_agreement_id_for_document');

    // Ensure option exists and assign value (even though disabled)
    ensureOptionExists(tenantSelect, tenantId, `Tenant ID: ${tenantId}`);
    ensureOptionExists(agreementSelect, agreementId, `Agreement ID: ${agreementId}`);

    // Set value to show it in the disabled dropdown
    tenantSelect.value = tenantId;
    agreementSelect.value = agreementId;
 document.getElementById('hidden_agreement_id').value = agreementId;
document.getElementById('hidden_tenant_id').value = tenantId;

}

function ensureOptionExists(selectEl, value, text) {
    // Check if the option with the specific value already exists
    if (!selectEl.querySelector(`option[value="${value}"]`)) {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        selectEl.appendChild(option);
    }
}


});

// Handle renewal mapping for both add and edit forms
document.addEventListener('change', function(e) {
    // Handle agreement type changes
    if (e.target.matches('#agreement_type, #edit_agreement_type')) {
        const prefix = e.target.id.includes('edit_') ? 'edit_' : '';
        const container = document.getElementById(`${prefix}renewalPercentageContainer`);
        
        if (container) {
            container.style.display = 
                e.target.value.toUpperCase() === 'RENEWAL' ? 'block' : 'none';
        }
    }
    
    // Handle tenant + agreement type changes for renewal mapping
    if (e.target.matches('#tenant_id, #edit_tenant_id, #agreement_type, #edit_agreement_type')) {
        const isEdit = e.target.id.includes('edit_');
        const prefix = isEdit ? 'edit_' : '';
        const tenantId = document.getElementById(`${prefix}tenant_id`).value;
        const agreementType = document.getElementById(`${prefix}agreement_type`).value;
        
        if (tenantId && agreementType) {
            fetchRenewalMapping(prefix, tenantId, agreementType);
        }
    }
    
    // Handle renewal percentage changes
    if (e.target.matches('#renewal_percentage, #edit_renewal_percentage')) {
    const prefix = e.target.id.includes('edit_') ? 'edit_' : '';
console.log('Prefix:', prefix);

const agreementIdInput = document.getElementById(`${prefix}agreement_id`);
if (!agreementIdInput) {
    console.error(`❗ Element with id="${prefix}agreement_id" not found.`);
    return;
}
const agreementId = agreementIdInput.value;

        const renewalPercentage = e.target.value;
        const agreementType = document.getElementById(`${prefix}agreement_type`).value;
        
        if (agreementId && renewalPercentage) {
            console.log(agreementId)
            fetchRenewalCalculation(prefix, agreementId, renewalPercentage, agreementType);
        }
    }
});

// Helper functions



async function fetchRenewalMapping(prefix, tenantId, agreementType) {
    try {
        const response = await fetch(
            `/renewal-mapping?tenant_id=${tenantId}&agreement_type=${encodeURIComponent(agreementType)}`
        );
        const result = await response.json();
        const mapping = result.data?.[0] || {};
        
        const fieldsToUpdate = [
            'branch_id', 'building_id', 'agreement_id', 'floor_id',
            'property_id', 'rental_type_id', 'notice_period_status', 'price_id',
            'status_master', 'agreement_from_date', 'agreement_to_date',
            'notice_period_days', 'common_maintenance_amount', 'rental_amount',
            'total_rent_amount', 'vat_rent_amount', 'final_rent_amount_with_vat', 'remarks'
        ];
        
        fieldsToUpdate.forEach(field => {
            const element = document.getElementById(`${prefix}${field}`);
            if (!element) return;
            
            let value = mapping[field.toUpperCase()] || '';
            
            if (field.includes('date') && value) {
                value = value.split(' ')[0];
            }
            
            element.value = value;
        });
        
        // Reset deposit fields
        ['deposit_amount', 'vat_deposit_amount', 'final_deposit_amount_with_vat'].forEach(field => {
            const element = document.getElementById(`${prefix}${field}`);
            if (element) element.value = '0';
        });

           // Manually trigger change events on property_id and rental_type_id so price_id updates
    const propertyEl = document.getElementById(prefix + 'property_id');
    const rentalTypeEl = document.getElementById(prefix + 'rental_type_id');

    if (propertyEl) propertyEl.dispatchEvent(new Event('change'));
    if (rentalTypeEl) rentalTypeEl.dispatchEvent(new Event('change'));
        
    } catch (error) {
        console.error('Renewal mapping error:', error);
    }
}

async function fetchRenewalCalculation(prefix, agreementId, renewalPercentage, agreementType) {
    try {
        const response = await fetch(
            `/increase-vat?agreement_id=${agreementId}&renewal_percentage=${renewalPercentage}&agreement_type=${agreementType}`
        );
        const result = await response.json();
        const updatedData = result.data?.[0] || {};

        const fieldsToUpdate = ['rental_amount','common_maintenance_amount','With_holding_vat_percentage','vat_percentage'];

        fieldsToUpdate.forEach(field => {
            const id = `${prefix}${field}`;
            const element = document.getElementById(id);

            if (element) {
                const value = updatedData[field.toUpperCase()];
                element.value = value !== undefined ? value : 0;
            } else {
                console.warn(`❗ Element with ID "${id}" not found in DOM`);
            }
            calculateAll();
        });

    } catch (error) {
        console.error('Renewal calculation error:', error);
    }
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
 calculateAll()



 ///INVOICE DETAILS JS
 


});
