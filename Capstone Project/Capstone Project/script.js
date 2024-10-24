document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const userIdInput = document.getElementById('userId');
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const userId = userIdInput.value;
        const password = passwordInput.value;

        if (!isValidUserId(userId)) {
            alert('Invalid User ID. It should start with E or M followed by 5 numbers.');
            return;
        }

        // If validation passes, submit the form
        this.submit();
    });

    togglePasswordButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️' : '🔒';
    });

    function isValidUserId(userId) {
        const regex = /^[EM]\d{5}$/;
        return regex.test(userId);
    }
});