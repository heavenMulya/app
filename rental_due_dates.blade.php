<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Yearly Property Tenant Table</title>
<style>
  * {
    box-sizing: border-box;
  }
  
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: transparent;
    margin: 0;
    padding: 20px;
    min-height: 100vh;
  }
  
  .container {
    max-width: 1200px;
    margin: 0 auto;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
  }
  
  .controls {
    background: linear-gradient(135deg, #00cfe8 0%, #17a2b8 100%);
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
  }
  
  button {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
  }
  
  button:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }
  
  #currentYearLabel {
    font-weight: bold;
    font-size: 1.8em;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  }
  
  table {
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: white;
  }
  
  th, td {
    border: 1px solid #e1e8ed;
    padding: 12px 15px;
    text-align: center;
    white-space: nowrap;
    transition: all 0.3s ease;
  }
  
  th {
    background: linear-gradient(135deg, #495057 0%, #343a40 100%);
    color: white;
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    position: relative;
  }
  
  th:first-child {
    background: linear-gradient(135deg, #00cfe8 0%, #17a2b8 100%);
  }
  
  .property-name {
    background: linear-gradient(135deg, #00cfe8 0%, #17a2b8 100%);
    color: white;
    font-weight: bold;
    text-align: left;
    font-size: 1.1em;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
  }
  
  .property-name:hover {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    transform: translateX(5px);
  }
  
  .property-name::after {
    content: '▼';
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    transition: transform 0.3s ease;
  }
  
  .property-name.collapsed::after {
    transform: translateY(-50%) rotate(-90deg);
  }
  
  /* Tooltip styles */
  .tooltip {
    position: absolute;
    background: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    z-index: 1000;
    pointer-events: none;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
  }
  
  .tooltip.show {
    opacity: 1;
    transform: translateY(-5px);
  }
  
  .tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: rgba(0, 0, 0, 0.9) transparent transparent transparent;
  }
  
  .tenant-row {
    transition: all 0.3s ease;
  }
  
  .tenant-row.hidden {
    display: none;
  }
  
  .tenant-name {
    background: #f8f9fa;
    text-align: left;
    font-weight: 600;
    color: #495057;
    border-right: 3px solid #dee2e6;
  }
  
  .vacant {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
    color: #856404;
    font-weight: bold;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  }
  
  td:not(.property-name):not(.tenant-name):not(.vacant) {
    background: white;
    font-weight: 600;
    color: #495057;
    cursor: pointer;
    position: relative;
  }
  
  td:not(.property-name):not(.tenant-name):not(.vacant):hover {
    transform: scale(1.05);
    z-index: 10;
    position: relative;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }
  
  /* Payment status colors - using more specific selectors */
  td.paid {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    color: white !important;
    font-weight: bold;
  }
  
  td.paid:hover {
    background: linear-gradient(135deg, #1e7e34 0%, #17a085 100%) !important;
    color: white !important;
  }
  
  td.overdue {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    color: white !important;
    font-weight: bold;
  }
  
  td.overdue:hover {
    background: linear-gradient(135deg, #bd2130 0%, #a71e2a 100%) !important;
    color: white !important;
  }
  
  td.future {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
    color: white !important;
    font-weight: bold;
  }
  
  td.future:hover {
    background: linear-gradient(135deg, #495057 0%, #343a40 100%) !important;
    color: white !important;
  }
  
  /* Property row cells (empty cells under property name) */
  tr:first-child td:not(.property-name) {
    background: #e9ecef;
    border-top: 3px solid #00cfe8;
  }
  
  /* Add some animation */
  table {
    animation: fadeIn 0.5s ease-in;
  }
  
  @keyframes fadeIn {
    from { 
      opacity: 0; 
      transform: translateY(20px); 
    }
    to { 
      opacity: 1; 
      transform: translateY(0); 
    }
  }
  
  /* Responsive design */
  @media (max-width: 768px) {
    body {
      padding: 10px;
    }
    
    th, td {
      padding: 8px 6px;
      font-size: 0.9em;
    }
    
    .controls {
      flex-direction: column;
      gap: 15px;
      padding: 15px;
    }
    
    #currentYearLabel {
      font-size: 1.5em;
    }
    
    button {
      padding: 10px 16px;
    }
  }
  
  /* Add subtle shadows to create depth */
  .container {
    position: relative;
  }
  
  .container::before {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    background: linear-gradient(135deg, #00cfe8 0%, #17a2b8 100%);
    border-radius: 20px;
    z-index: -1;
    opacity: 0.1;
    filter: blur(15px);
  }
</style>
</head>
<body>

<div class="container">
  <div class="controls">
    <button id="prevYearBtn">←</button>
    <span id="currentYearLabel"></span>
    <button id="nextYearBtn">→</button>
  </div>

  <table id="propertyTable">
    <thead>
      <!-- headers get generated here -->
    </thead>
    <tbody>
      <tr class="property-row" data-property="property1">
        <td class="property-name">Property 1</td>
        <!-- year header cells will be added here -->
      </tr>
      <tr class="tenant-row" data-property="property1">
        <td class="tenant-name">Heaven</td>
        <!-- month data cells -->
      </tr>
      <tr class="tenant-row" data-property="property1">
        <td class="tenant-name vacant">John (vacant)</td>
        <!-- colspan -->
      </tr>
      <tr class="tenant-row" data-property="property1">
        <td class="tenant-name">Rose</td>
        <!-- month data cells -->
      </tr>
      
      <tr class="property-row" data-property="property2">
        <td class="property-name">Property 2</td>
        <!-- year header cells will be added here -->
      </tr>
      <tr class="tenant-row" data-property="property2">
        <td class="tenant-name">Michael</td>
        <!-- month data cells -->
      </tr>
      <tr class="tenant-row" data-property="property2">
        <td class="tenant-name">Sarah</td>
        <!-- month data cells -->
      </tr>
      <tr class="tenant-row" data-property="property2">
        <td class="tenant-name vacant">David (vacant)</td>
        <!-- colspan -->
      </tr>
    </tbody>
  </table>
</div>

<script>
// Sample tenant data for both properties with payment history
const properties = {
  property1: {
    name: "Property 1",
    tenants: [
      { 
        name: "Heaven", 
        type: "occupied", 
        monthlyRent: 25,
        payments: {
          0: { paid: true, dueDate: 5, paidDate: 3 }, // Jan - paid early
          1: { paid: true, dueDate: 5, paidDate: 6 }, // Feb - paid late
          2: { paid: false, dueDate: 5 }, // Mar - overdue
          3: { paid: true, dueDate: 5, paidDate: 4 }, // Apr - paid
          4: { paid: false, dueDate: 5 }, // May - overdue
          5: { paid: true, dueDate: 5, paidDate: 5 }, // Jun - paid on time
          // Future months have no payment data
        }
      },
      { name: "John", type: "vacant", monthlyRent: 0 },
      { 
        name: "Rose", 
        type: "occupied", 
        monthlyRent: 12,
        payments: {
          0: { paid: true, dueDate: 10, paidDate: 8 }, // Jan - paid early
          1: { paid: true, dueDate: 10, paidDate: 12 }, // Feb - paid late
          2: { paid: true, dueDate: 10, paidDate: 10 }, // Mar - paid on time
          3: { paid: false, dueDate: 10 }, // Apr - overdue
          4: { paid: true, dueDate: 10, paidDate: 9 }, // May - paid
          5: { paid: false, dueDate: 10 }, // Jun - overdue
        }
      }
    ]
  },
  property2: {
    name: "Property 2", 
    tenants: [
      { 
        name: "Michael", 
        type: "occupied", 
        monthlyRent: 30,
        payments: {
          0: { paid: true, dueDate: 1, paidDate: 1 }, // Jan - paid on time
          1: { paid: true, dueDate: 1, paidDate: 2 }, // Feb - paid late
          2: { paid: true, dueDate: 1, paidDate: 1 }, // Mar - paid on time
          3: { paid: true, dueDate: 1, paidDate: 1 }, // Apr - paid on time
          4: { paid: false, dueDate: 1 }, // May - overdue
          5: { paid: true, dueDate: 1, paidDate: 1 }, // Jun - paid on time
        }
      },
      { 
        name: "Sarah", 
        type: "occupied", 
        monthlyRent: 18,
        payments: {
          0: { paid: true, dueDate: 15, paidDate: 14 }, // Jan - paid early
          1: { paid: false, dueDate: 15 }, // Feb - overdue
          2: { paid: true, dueDate: 15, paidDate: 16 }, // Mar - paid late
          3: { paid: true, dueDate: 15, paidDate: 15 }, // Apr - paid on time
          4: { paid: true, dueDate: 15, paidDate: 13 }, // May - paid early
          5: { paid: false, dueDate: 15 }, // Jun - overdue
        }
      },
      { name: "David", type: "vacant", monthlyRent: 0 }
    ]
  }
};

// Track collapsed properties
let collapsedProperties = new Set();

// Get current date info for payment status
function getCurrentDateInfo() {
  const now = new Date();
  return {
    currentMonth: now.getMonth(),
    currentDay: now.getDate(),
    currentYear: now.getFullYear()
  };
}

// Determine payment status for a month
function getPaymentStatus(tenant, monthIndex, year) {
  const currentDate = getCurrentDateInfo();
  const payment = tenant.payments && tenant.payments[monthIndex];
  
  // If it's a future year, all months are future
  if (year > currentDate.currentYear) {
    return 'future';
  }
  
  // If it's a past year, use payment data or assume overdue if no data
  if (year < currentDate.currentYear) {
    if (payment) {
      return payment.paid ? 'paid' : 'overdue';
    }
    return 'overdue'; // Assume overdue for past months without data
  }
  
  // Current year logic
  if (monthIndex > currentDate.currentMonth) {
    return 'future'; // Future months
  }
  
  if (monthIndex < currentDate.currentMonth) {
    // Past months in current year
    if (payment) {
      return payment.paid ? 'paid' : 'overdue';
    }
    return 'overdue'; // Assume overdue if no payment data
  }
  
  // Current month
  if (monthIndex === currentDate.currentMonth) {
    if (payment) {
      if (payment.paid) {
        return 'paid';
      } else {
        // Check if due date has passed
        const dueDate = payment.dueDate || 1;
        return currentDate.currentDay > dueDate ? 'overdue' : 'future';
      }
    } else {
      // No payment data for current month - assume due on 1st
      return currentDate.currentDay > 1 ? 'overdue' : 'future';
    }
  }
  
  return 'future';
}

// Create tooltip content
function createTooltipContent(tenant, monthIndex, year, status) {
  const monthName = monthNames[monthIndex];
  const payment = tenant.payments && tenant.payments[monthIndex];
  
  if (status === 'future') {
    const dueDate = payment ? payment.dueDate : 1;
    return `${monthName} ${year}<br>Due: ${monthName} ${dueDate}<br>Status: Not due yet`;
  }
  
  if (status === 'paid') {
    const dueDate = payment.dueDate || 1;
    const paidDate = payment.paidDate || dueDate;
    const statusText = paidDate <= dueDate ? 'Paid on time' : 'Paid late';
    return `${monthName} ${year}<br>Due: ${monthName} ${dueDate}<br>Paid: ${monthName} ${paidDate}<br>Amount: ${tenant.monthlyRent}<br>Status: ${statusText}`;
  }
  
  if (status === 'overdue') {
    const dueDate = payment ? payment.dueDate : 1;
    const currentDate = getCurrentDateInfo();
    const isCurrentYear = year === currentDate.currentYear;
    const isCurrentMonth = monthIndex === currentDate.currentMonth;
    
    let daysOverdue = 0;
    if (isCurrentYear && isCurrentMonth) {
      daysOverdue = Math.max(0, currentDate.currentDay - dueDate);
    } else if (year < currentDate.currentYear || (isCurrentYear && monthIndex < currentDate.currentMonth)) {
      // For simplicity, assume 30 days overdue for past months
      daysOverdue = 30;
    }
    
    return `${monthName} ${year}<br>Due: ${monthName} ${dueDate}<br>Amount: ${tenant.monthlyRent}<br>Status: Overdue${daysOverdue > 0 ? ` (${daysOverdue} days)` : ''}`;
  }
  
  return `${monthName} ${year}`;
}

const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

let currentYear = new Date().getFullYear();

// Elements
const currentYearLabel = document.getElementById('currentYearLabel');
const prevYearBtn = document.getElementById('prevYearBtn');
const nextYearBtn = document.getElementById('nextYearBtn');
const thead = document.querySelector("#propertyTable thead");
const tbody = document.querySelector("#propertyTable tbody");

// Tooltip element
let tooltip = null;

// Create tooltip element
function createTooltip() {
  if (!tooltip) {
    tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    document.body.appendChild(tooltip);
  }
  return tooltip;
}

// Show tooltip
function showTooltip(e, content) {
  const tooltipEl = createTooltip();
  tooltipEl.innerHTML = content;
  tooltipEl.classList.add('show');
  
  const rect = e.target.getBoundingClientRect();
  tooltipEl.style.left = rect.left + (rect.width / 2) - (tooltipEl.offsetWidth / 2) + 'px';
  tooltipEl.style.top = rect.top - tooltipEl.offsetHeight - 10 + 'px';
}

// Hide tooltip
function hideTooltip() {
  if (tooltip) {
    tooltip.classList.remove('show');
  }
}

// Generate headers for given year
function generateHeaders(year) {
  thead.innerHTML = '';
  
  // First row: Year row
  const trYear = document.createElement('tr');
  const thSidebar = document.createElement('th');
  thSidebar.textContent = 'Property/Tenant';
  trYear.appendChild(thSidebar);
  
  const thYear = document.createElement('th');
  thYear.colSpan = 12;
  thYear.textContent = year;
  thYear.style.textAlign = "center";
  trYear.appendChild(thYear);
  thead.appendChild(trYear);

  // Second row: Months header row
  const trMonths = document.createElement('tr');
  const thEmpty = document.createElement('th');
  thEmpty.textContent = '';
  trMonths.appendChild(thEmpty);
  
  for(let i=0; i<12; i++) {
    const th = document.createElement('th');
    th.textContent = monthNames[i];
    trMonths.appendChild(th);
  }
  thead.appendChild(trMonths);
}

// Fill tenant month data for all properties
function fillTenantData() {
  // Clear existing month cells first
  const allRows = tbody.querySelectorAll("tr");

  allRows.forEach((row) => {
    // Remove old month cells (everything except first column)
    while(row.cells.length > 1) {
      row.deleteCell(1);
    }
    
    const propertyId = row.dataset.property;
    
    if(row.classList.contains('property-row')) {
      // Property header row - add empty cells
      for(let i = 0; i < 12; i++) {
        const td = document.createElement('td');
        td.textContent = '';
        row.appendChild(td);
      }
    } else if(row.classList.contains('tenant-row') && propertyId) {
      // Find tenant data
      const property = properties[propertyId];
      const tenantName = row.cells[0].textContent.toLowerCase().replace(' (vacant)', '');
      const tenant = property.tenants.find(t => t.name.toLowerCase() === tenantName);
      
      if(tenant && tenant.type === 'vacant') {
        // Vacant tenant - single cell spanning all months
        const td = document.createElement('td');
        td.colSpan = 12;
        td.className = 'vacant';
        td.textContent = 'vacant';
        row.appendChild(td);
      } else if(tenant) {
        // Occupied tenant - individual month cells with payment status
        for(let i = 0; i < 12; i++) {
          const td = document.createElement('td');
          td.textContent = `${tenant.monthlyRent}`;
          
          // Add payment status class
          const status = getPaymentStatus(tenant, i, currentYear);
          td.classList.add(status);
          
          // Add tooltip functionality
          const tooltipContent = createTooltipContent(tenant, i, currentYear, status);
          
          td.addEventListener('mouseenter', (e) => {
            showTooltip(e, tooltipContent);
          });
          
          td.addEventListener('mouseleave', hideTooltip);
          
          // Prevent tooltip from showing on property cells
          td.addEventListener('mousemove', (e) => {
            if (tooltip && tooltip.classList.contains('show')) {
              const rect = e.target.getBoundingClientRect();
              tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
              tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
            }
          });
          
          row.appendChild(td);
        }
      }
    }
  });
}

// Toggle property collapse/expand
function toggleProperty(propertyId) {
  const tenantRows = tbody.querySelectorAll(`.tenant-row[data-property="${propertyId}"]`);
  const propertyRow = tbody.querySelector(`.property-row[data-property="${propertyId}"] .property-name`);
  
  if(collapsedProperties.has(propertyId)) {
    // Expand
    collapsedProperties.delete(propertyId);
    propertyRow.classList.remove('collapsed');
    tenantRows.forEach(row => row.classList.remove('hidden'));
  } else {
    // Collapse  
    collapsedProperties.add(propertyId);
    propertyRow.classList.add('collapsed');
    tenantRows.forEach(row => row.classList.add('hidden'));
  }
}

// Add click listeners to property headers
function addPropertyClickListeners() {
  const propertyNames = tbody.querySelectorAll('.property-name');
  propertyNames.forEach(propertyElement => {
    propertyElement.addEventListener('click', (e) => {
      const propertyRow = e.target.closest('.property-row');
      const propertyId = propertyRow.dataset.property;
      toggleProperty(propertyId);
    });
  });
}

function renderYear(year) {
  currentYearLabel.textContent = year;
  generateHeaders(year);
  fillTenantData();
  addPropertyClickListeners();
}

// Button event listeners
prevYearBtn.addEventListener('click', () => {
  currentYear--;
  renderYear(currentYear);
});

nextYearBtn.addEventListener('click', () => {
  currentYear++;
  renderYear(currentYear);
});

// Initial render
renderYear(currentYear);
</script>

</body>
</html>