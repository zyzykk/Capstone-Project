document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentAdviceForm');
    const uploadButton = document.getElementById('uploadInvoice');
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.name = 'invoice';
    fileInput.accept = '.pdf,.doc,.docx,.jpg,.jpeg,.png';
    fileInput.style.display = 'none';
    uploadButton.parentNode.insertBefore(fileInput, uploadButton.nextSibling);

    uploadButton.addEventListener('click', function() {
        fileInput.click();
    });

    // Check for success message in session and display alert
    const urlParams = new URLSearchParams(window.location.search);
    const successMessage = urlParams.get('success_message');
    if (successMessage) {
        alert(decodeURIComponent(successMessage));
    }

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            uploadButton.textContent = 'File selected: ' + fileInput.files[0].name;
        } else {
            uploadButton.textContent = 'Upload Invoice';
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (validateForm()) {
            this.submit();
        }
    });

    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                showError(field, 'This field is required');
            } else {
                clearError(field);
            }
        });

        const amountField = document.getElementById('paymentAmount');
        if (amountField.value && parseFloat(amountField.value) <= 0) {
            isValid = false;
            showError(amountField, 'Amount must be greater than 0');
        }

        return isValid;
    }

    function showError(field, message) {
        clearError(field);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
        field.classList.add('error-input');
    }

    function clearError(field) {
        const errorDiv = field.parentNode.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
        field.classList.remove('error-input');
    }
});