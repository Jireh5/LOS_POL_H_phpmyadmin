// Helper function to show messages
function showMessage(elementId, message, isError = true) {
    const element = document.getElementById(elementId);
    element.textContent = message;
    element.classList.add('show');
    
    // Hide the opposite message type
    const oppositeId = isError ? 'success-message' : 'error-message';
    const oppositeElement = document.getElementById(oppositeId);
    oppositeElement.classList.remove('show');
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        element.classList.remove('show');
    }, 5000);
}

// Helper function to set button loading state
function setButtonLoading(buttonId, isLoading) {
    const button = document.getElementById(buttonId);
    if (isLoading) {
        button.classList.add('loading');
        button.disabled = true;
    } else {
        button.classList.remove('loading');
        button.disabled = false;
    }
}

// Login Form Handler
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        
        // Basic validation
        if (!username || !password) {
            showMessage('error-message', 'Please fill in all fields');
            return;
        }
        
        setButtonLoading('loginBtn', true);
        
        try {
            const response = await fetch('php/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            });
            
            const data = await response.json();
            
            if (data.success) {
                showMessage('success-message', 'Login successful! Redirecting...', false);
                // Redirect to admin dashboard after 1 second
                setTimeout(() => {
                    window.location.href = 'admin_ui.html';
                }, 1000);
            } else {
                showMessage('error-message', data.message || 'Login failed');
                setButtonLoading('loginBtn', false);
            }
        } catch (error) {
            showMessage('error-message', 'An error occurred. Please try again.');
            setButtonLoading('loginBtn', false);
        }
    });
}

// Signup Form Handler
const signupForm = document.getElementById('signupForm');
if (signupForm) {
    signupForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        // Validation
        if (!username || !email || !password || !confirmPassword) {
            showMessage('error-message', 'Please fill in all fields');
            return;
        }
        
        if (username.length < 3) {
            showMessage('error-message', 'Username must be at least 3 characters long');
            return;
        }
        
        if (password.length < 8) {
            showMessage('error-message', 'Password must be at least 8 characters long');
            return;
        }
        
        if (password !== confirmPassword) {
            showMessage('error-message', 'Passwords do not match');
            return;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showMessage('error-message', 'Please enter a valid email address');
            return;
        }
        
        setButtonLoading('signupBtn', true);
        
        try {
            const response = await fetch('php/signup.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            });
            
            const data = await response.json();
            
            if (data.success) {
                showMessage('success-message', 'Account created successfully! Redirecting to login...', false);
                // Redirect to login page after 2 seconds
                setTimeout(() => {
                    window.location.href = 'login.html';
                }, 2000);
            } else {
                showMessage('error-message', data.message || 'Signup failed');
                setButtonLoading('signupBtn', false);
            }
        } catch (error) {
            showMessage('error-message', 'An error occurred. Please try again.');
            setButtonLoading('signupBtn', false);
        }
    });
}

// Password visibility toggle (optional enhancement)
function addPasswordToggle() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            if (this.value.length > 0) {
                this.style.letterSpacing = '0.1em';
            } else {
                this.style.letterSpacing = 'normal';
            }
        });
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    addPasswordToggle();
});