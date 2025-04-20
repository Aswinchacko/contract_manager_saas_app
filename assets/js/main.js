// Handle form submissions with AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Handle todo list checkboxes
    const todoCheckboxes = document.querySelectorAll('.todo-item .form-check-input');
    todoCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.checked) {
                label.style.textDecoration = 'line-through';
                label.style.color = '#858796';
            } else {
                label.style.textDecoration = 'none';
                label.style.color = '#000';
            }
        });
    });

    // Handle contract form submission
    const contractForm = document.querySelector('#contract-form');
    if (contractForm) {
        contractForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Add contract form submission logic here
            alert('Contract saved successfully!');
        });
    }

    // Handle client form submission
    const clientForm = document.querySelector('#client-form');
    if (clientForm) {
        clientForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Add client form submission logic here
            alert('Client information saved successfully!');
        });
    }
});

// Handle subscription management
function updateSubscription(plan) {
    // This would be replaced with actual subscription update logic
    alert(`Subscription updated to ${plan} plan`);
}

// Handle contract status updates
function updateContractStatus(contractId, status) {
    // This would be replaced with actual contract status update logic
    alert(`Contract ${contractId} status updated to ${status}`);
}

// Handle PDF generation
function generatePDF(contractId) {
    // This would be replaced with actual PDF generation logic
    alert(`Generating PDF for contract ${contractId}`);
}

// Handle client search
function searchClients(query) {
    // This would be replaced with actual client search logic
    console.log(`Searching clients for: ${query}`);
}

// Handle contract search
function searchContracts(query) {
    // This would be replaced with actual contract search logic
    console.log(`Searching contracts for: ${query}`);
}

// Handle notifications
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show`;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 5000);
}

// Handle responsive sidebar
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

// Handle date pickers
function initializeDatePickers() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        if (!input.value) {
            input.value = new Date().toISOString().split('T')[0];
        }
    });
}

// Initialize tooltips
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Initialize popovers
function initializePopovers() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// Initialize all components
document.addEventListener('DOMContentLoaded', function() {
    initializeDatePickers();
    initializeTooltips();
    initializePopovers();
}); 