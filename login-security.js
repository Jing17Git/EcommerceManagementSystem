let currentAction = null;

// Toggle 2FA Section
document.getElementById('toggle2FA').addEventListener('change', function() {
    const content = document.getElementById('twoFactorContent');
    content.style.display = this.checked ? 'block' : 'none';
});

// Auto-focus next input for verification code
document.querySelectorAll('.code-input').forEach((input, index, inputs) => {
    input.addEventListener('input', function() {
        if (this.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
            inputs[index - 1].focus();
        }
    });
});

// Verify 2FA
function verify2FA() {
    const codes = Array.from(document.querySelectorAll('.code-input'))
        .map(input => input.value)
        .join('');

    if (codes.length !== 6) {
        showAlert('Please enter the complete 6-digit code', 'error');
        return;
    }

    // Simulate verification
    showAlert('Verifying code...', 'success');
    
    setTimeout(() => {
        showAlert('✓ Two-Factor Authentication enabled successfully!', 'success');
        
        // Update security overview
        const twoFactorCard = document.querySelectorAll('.security-card')[1];
        twoFactorCard.querySelector('.security-icon').textContent = '✓';
        twoFactorCard.querySelector('.security-icon').classList.remove('warning');
        twoFactorCard.querySelector('.security-icon').classList.add('success');
        twoFactorCard.querySelector('p').textContent = 'Enabled';
        twoFactorCard.querySelector('.status-badge').textContent = 'Active';
        twoFactorCard.querySelector('.status-badge').classList.remove('warning');
        twoFactorCard.querySelector('.status-badge').classList.add('success');
    }, 1500);
}

// Download Backup Codes
function downloadBackupCodes() {
    const codes = Array.from(document.querySelectorAll('.codes-grid code'))
        .map(code => code.textContent)
        .join('\n');
    
    const blob = new Blob([`Two-Factor Authentication Backup Codes\n\n${codes}\n\nKeep these codes safe!`], 
        { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = '2fa-backup-codes.txt';
    a.click();
    URL.revokeObjectURL(url);
    
    showAlert('✓ Backup codes downloaded successfully', 'success');
}

// Toggle Password Visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    
    if (field.type === 'password') {
        field.type = 'text';
        button.textContent = '🙈';
    } else {
        field.type = 'password';
        button.textContent = '👁️';
    }
}

// Password Strength Checker
document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    const strengthFill = document.querySelector('.strength-fill');
    const strengthText = document.querySelector('.strength-text');
    
    let strength = 0;
    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/)) strength += 25;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 25;
    
    strengthFill.style.width = strength + '%';
    
    if (strength <= 25) {
        strengthFill.style.background = '#e53e3e';
        strengthText.textContent = 'Weak password';
    } else if (strength <= 50) {
        strengthFill.style.background = '#ed8936';
        strengthText.textContent = 'Fair password';
    } else if (strength <= 75) {
        strengthFill.style.background = '#ecc94b';
        strengthText.textContent = 'Good password';
    } else {
        strengthFill.style.background = '#48bb78';
        strengthText.textContent = 'Strong password';
    }
});

// Change Password
function changePassword(event) {
    event.preventDefault();
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (newPassword !== confirmPassword) {
        showAlert('New passwords do not match', 'error');
        return;
    }
    
    if (newPassword.length < 8) {
        showAlert('Password must be at least 8 characters long', 'error');
        return;
    }
    
    currentAction = 'changePassword';
    showModal(
        'Confirm Password Change',
        'Are you sure you want to change your password? You will need to log in again with your new password.'
    );
}

// Logout Single Session
function logoutSession(sessionId) {
    currentAction = { type: 'logoutSession', id: sessionId };
    showModal(
        'Logout Session',
        'Are you sure you want to logout this device? This action cannot be undone.'
    );
}

// Logout All Sessions
function logoutAllSessions() {
    currentAction = 'logoutAll';
    showModal(
        'Logout All Devices',
        'Are you sure you want to logout from all devices except this one? You will need to log in again on those devices.'
    );
}

// Show Modal
function showModal(title, message) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('modal').classList.add('show');
}

// Close Modal
function closeModal() {
    document.getElementById('modal').classList.remove('show');
    currentAction = null;
}

// Confirm Action
function confirmAction() {
    if (currentAction === 'changePassword') {
        executePasswordChange();
    } else if (currentAction === 'logoutAll') {
        executeLogoutAll();
    } else if (currentAction && currentAction.type === 'logoutSession') {
        executeLogoutSession(currentAction.id);
    }
    closeModal();
}

// Execute Password Change
function executePasswordChange() {
    showAlert('Updating password...', 'success');
    
    setTimeout(() => {
        showAlert('✓ Password changed successfully!', 'success');
        document.querySelector('.password-form').reset();
        document.querySelector('.strength-fill').style.width = '0%';
        document.querySelector('.strength-text').textContent = 'Password strength';
    }, 1500);
}

// Execute Logout Session
function executeLogoutSession(sessionId) {
    showAlert('Logging out device...', 'success');
    
    setTimeout(() => {
        const sessionItems = document.querySelectorAll('.session-item');
        sessionItems[sessionId - 1].style.opacity = '0.5';
        sessionItems[sessionId - 1].style.pointerEvents = 'none';
        
        showAlert('✓ Device logged out successfully', 'success');
        
        // Update active sessions count
        const activeCount = document.querySelectorAll('.session-item:not([style*="opacity"])').length;
        document.querySelectorAll('.security-card')[2].querySelector('p').textContent = 
            `${activeCount} devices`;
    }, 1000);
}

// Execute Logout All
function executeLogoutAll() {
    showAlert('Logging out all devices...', 'success');
    
    setTimeout(() => {
        const sessionItems = document.querySelectorAll('.session-item:not(.current)');
        sessionItems.forEach(item => {
            item.style.opacity = '0.5';
            item.style.pointerEvents = 'none';
        });
        
        showAlert('✓ All other devices logged out successfully', 'success');
        
        // Update active sessions count
        document.querySelectorAll('.security-card')[2].querySelector('p').textContent = '1 device';
    }, 1500);
}

// Show Alert
function showAlert(message, type) {
    const alert = document.getElementById('alert');
    alert.textContent = message;
    alert.className = `alert ${type}`;
    alert.style.display = 'flex';
    
    setTimeout(() => {
        alert.style.display = 'none';
    }, 5000);
}

// Close modal on outside click
document.getElementById('modal').addEventListener('click', (e) => {
    if (e.target.id === 'modal') {
        closeModal();
    }
});
