document.addEventListener('DOMContentLoaded', function () {

    function initPasswordFields(modal) {
        // Query elements inside this modal
        const passwordInput = modal.querySelector('.password-input');
        const passwordConfirmInput = modal.querySelector('.password-confirmation-input');
        const generateBtn = modal.querySelector('.generate-password-btn');
        const strengthBadge = modal.querySelector('.password-strength-badge');

        if (!passwordInput || !generateBtn || !strengthBadge) return;

        // Generate strong random password
        function generatePassword(length = 12) {
            const lower = 'abcdefghijklmnopqrstuvwxyz';
            const upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '0123456789';
            const symbols = '!@#$%^&*()_+~`|}{[]:;?><,./-=';
            const all = lower + upper + numbers + symbols;

            let pwd = '';
            pwd += lower[Math.floor(Math.random() * lower.length)];
            pwd += upper[Math.floor(Math.random() * upper.length)];
            pwd += numbers[Math.floor(Math.random() * numbers.length)];
            pwd += symbols[Math.floor(Math.random() * symbols.length)];

            for (let i = 4; i < length; i++) {
                pwd += all[Math.floor(Math.random() * all.length)];
            }

            return pwd.split('').sort(() => 0.5 - Math.random()).join('');
        }

        // Check password strength
        function checkStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[\!\@\#\$\%\^\&\*\(\)\_\+\~\`\|\}\{\[\]\:;?><,./-=]/.test(password)) strength++;

            if (strength <= 2) return { text: 'ضعيفة', class: 'bg-danger' };
            if (strength <= 4) return { text: 'متوسطة', class: 'bg-warning' };
            return { text: 'قوية', class: 'bg-success' };
        }

        // Update strength badge
        function updateStrength(password) {
            const strength = checkStrength(password);
            strengthBadge.textContent = strength.text;
            strengthBadge.className = `badge ${strength.class}`;
        }

        // Generate password button click
        generateBtn.addEventListener('click', function () {
            const pwd = generatePassword();
            passwordInput.value = pwd;
            updateStrength(pwd);

            // Dynamically update confirmation input
            const confirmInput = modal.querySelector('.password-confirmation-input');
            if (confirmInput) confirmInput.value = pwd;
        });

        // Live typing on password input
        passwordInput.addEventListener('input', function () {
            updateStrength(passwordInput.value);
        });
    }

    // Initialize password fields when modal is shown
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            initPasswordFields(modal);
        });
    });

});
