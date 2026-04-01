<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .forgot-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            margin: 1rem;
        }
        
        .forgot-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .forgot-header h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }
        
        .forgot-header p {
            color: #555;
            margin-bottom: 0;
            font-size: 1.1rem;
            line-height: 1.5;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            color: #333;
            font-weight: 500;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            font-size: 1rem;
            color: #333;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
            color: #333;
            outline: none;
        }
        
        .form-control::placeholder {
            color: #666;
            font-size: 0.95rem;
        }
        
        .btn-forgot {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-forgot:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-test {
            background: #28a745;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            color: white;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .btn-test:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .back-to-login a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: none;
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .otp-form {
            display: none;
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .otp-input {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 8px;
        }
        
        .form-step {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 10px;
        }
        
        .step.active {
            background: #667eea;
            color: white;
        }
        
        .step.completed {
            background: #28a745;
            color: white;
        }
        
        .step-line {
            flex: 1;
            height: 2px;
            background: #e9ecef;
            margin: 0 10px;
        }
        
        .step-line.completed {
            background: #28a745;
        }
        
        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .forgot-container {
                margin: 0;
                padding: 1.5rem;
                width: 100%;
                max-width: 100%;
                border-radius: 12px;
            }
            
            .forgot-header {
                margin-bottom: 1.5rem;
            }
            
            .forgot-header h4 {
                font-size: 1.5rem;
            }
            
            .forgot-header p {
                font-size: 1rem;
                color: #555;
            }
            
            .form-label {
                font-size: 1rem;
                color: #333;
            }
            
            .form-control {
                font-size: 1rem;
                color: #333;
                padding: 0.9rem;
            }
            
            .form-control::placeholder {
                font-size: 0.95rem;
                color: #666;
            }
            
            .form-step {
                margin-bottom: 1.5rem;
            }
            
            .step {
                width: 35px;
                height: 35px;
                margin: 0 8px;
                font-size: 0.9rem;
            }
            
            .btn-forgot {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }
            
            .alert {
                font-size: 0.85rem;
                padding: 0.8rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 0 !important;
                margin: 0 !important;
                min-height: 100vh !important;
                display: block !important;
            }
            
            .mobile-full-screen {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                margin: 0 !important;
                padding: 1.5rem !important;
                width: 100vw !important;
                height: 100vh !important;
                max-width: 100vw !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow-y: auto !important;
                background: white !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            
            .forgot-container {
                position: relative !important;
                width: 95% !important;
                height: auto !important;
                max-width: 95% !important;
                border-radius: 12px !important;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
                background: white !important;
                padding: 2rem !important;
                margin: 0 !important;
            }
            
            .forgot-header h4 {
                font-size: 1.8rem;
                margin-bottom: 0.5rem;
                color: #000000;
                font-weight: 700;
            }
            
            .forgot-header p {
                font-size: 1.3rem;
                color: #333333;
                line-height: 1.5;
                font-weight: 500;
            }
            
            .form-label {
                font-size: 1.3rem;
                color: #000000;
                font-weight: 700;
                margin-bottom: 0.8rem;
            }
            
            .form-control {
                font-size: 1.3rem;
                color: #000000;
                padding: 1.1rem;
                background: #ffffff;
                border: 3px solid #333333;
                border-radius: 8px;
                font-weight: 500;
            }
            
            .form-control:focus {
                border-color: #667eea;
                color: #000000;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
            }
            
            .form-control::placeholder {
                font-size: 1.2rem;
                color: #666666;
                font-weight: 500;
            }
            
            .form-step {
                margin-bottom: 1rem;
            }
            
            .step {
                width: 30px;
                height: 30px;
                margin: 0 5px;
                font-size: 0.8rem;
            }
            
            .step-line {
                margin: 0 5px;
            }
            
            .mb-3 {
                margin-bottom: 1rem !important;
            }
            
            .form-control {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .otp-input {
                font-size: 20px;
                letter-spacing: 6px;
                padding: 0.8rem;
            }
            
            .btn-forgot {
                padding: 1rem 1.5rem;
                font-size: 1.2rem;
                font-weight: 700;
            }
            
            .btn-test {
                padding: 0.6rem 1.2rem;
                font-size: 1rem;
                font-weight: 600;
            }
            
            .alert {
                font-size: 1rem;
                padding: 1rem;
                margin-bottom: 1.2rem;
            }
            
            .back-to-login {
                margin-top: 1.2rem;
            }
            
            .back-to-login a {
                font-size: 1rem;
                font-weight: 600;
            }
            
            .otp-input {
                font-size: 24px;
                letter-spacing: 8px;
                padding: 1.1rem;
                font-weight: 700;
                color: #000000;
                background: #ffffff;
                border: 3px solid #333333;
                border-radius: 8px;
            }
            
            .forgot-container {
                padding: 0.8rem;
                width: 100%;
                max-width: 100%;
                border-radius: 8px;
            }
            
            .forgot-header h4 {
                font-size: 1.1rem;
            }
            
            .form-control {
                padding: 0.6rem;
                font-size: 0.85rem;
            }
            
            .otp-input {
                font-size: 18px;
                letter-spacing: 4px;
                padding: 0.6rem;
            }
            
            .btn-forgot {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 360px) {
            body {
                padding: 2px;
            }
            
            .forgot-container {
                padding: 0.8rem;
                width: 100%;
                max-width: 100%;
                border-radius: 8px;
            }
            
            .forgot-header h4 {
                font-size: 1.1rem;
            }
            
            .form-control {
                padding: 0.6rem;
                font-size: 0.85rem;
            }
            
            .otp-input {
                font-size: 18px;
                letter-spacing: 4px;
                padding: 0.6rem;
            }
            
            .btn-forgot {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <!-- Mobile Full Screen Wrapper -->
        <div class="mobile-full-screen">
        <!-- Progress Steps -->
        <div class="form-step">
            <div class="step {{ session('show_otp_form') ? 'completed' : 'active' }}" id="step1">1</div>
            <div class="step-line {{ session('show_otp_form') ? 'completed' : '' }}"></div>
            <div class="step {{ session('show_otp_form') ? 'active' : '' }}" id="step2">2</div>
        </div>
        
        <!-- Email Form -->
        <div id="emailForm" {{ session('show_otp_form') ? 'style="display: none;"' : '' }}>
            <div class="forgot-header">
                <i class="bi bi-envelope-fill text-primary fs-1 mb-3"></i>
                <h4>Forgot Password?</h4>
                <p>Enter your email address to receive a password reset code</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.submit') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                </div>
                
                <button type="submit" class="btn btn-forgot">
                    <i class="bi bi-send me-2"></i>Send Reset Code
                </button>
            </form>
        </div>
        
        <!-- OTP Form -->
        <div id="otpForm" {{ session('show_otp_form') ? '' : 'style="display: none;"' }}>
            <div class="forgot-header">
                <i class="bi bi-shield-check text-success fs-1 mb-3"></i>
                <h4>Enter Reset Code</h4>
                <p>We've sent a 4-digit code to {{ session('reset_email') }}</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.verify-otp') }}">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                
                <div class="mb-3">
                    <label for="otp" class="form-label">Verification Code (4 digits)</label>
                    <input type="text" class="form-control otp-input" id="otp" name="otp" placeholder="Enter 4-digit code" maxlength="4" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                </div>
                
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-forgot">
                        <i class="bi bi-check-circle me-2"></i>Reset Password
                    </button>
                    
                    <button type="button" class="btn btn-secondary" onclick="resendOTP()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Resend Code
                    </button>
                </div>
            </form>
        </div>
            
        <div class="back-to-login">
            <a href="/login">
                <i class="bi bi-arrow-left me-1"></i>Back to Login
            </a>
            </div>
        </div>
    </div>
    </div>

    <!-- Test Email Modal -->
    <div class="modal fade" id="testEmailModal" tabindex="-1" aria-labelledby="testEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testEmailModalLabel">
                        <i class="bi bi-envelope-check me-2"></i>Test Email Configuration
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="testEmail" class="form-label">Test Email Address:</label>
                        <input type="email" class="form-control" id="testEmail" placeholder="Enter test email address" value="your-test-email@example.com">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-test" onclick="sendTestEmail()">
                            <i class="bi bi-send me-2"></i>Send Test Email
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearTestResult()">
                            <i class="bi bi-x-circle me-2"></i>Clear
                        </button>
                    </div>
                    
                    <div id="testResult" class="mt-3" style="display: none;">
                        <!-- Test result will be shown here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-focus OTP input when form is shown
        if (document.getElementById('otpForm').style.display !== 'none') {
            document.getElementById('otp').focus();
        }
        
        // Resend OTP function
        function resendOTP() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('password.resend-otp') }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            document.body.appendChild(form);
            form.submit();
        }
        
        // Send test email function
        function sendTestEmail() {
            const email = document.getElementById('testEmail').value;
            const resultDiv = document.getElementById('testResult');
            
            if (!email) {
                showTestResult('danger', 'Please enter an email address');
                return;
            }
            
            // Show loading
            resultDiv.style.display = 'block';
            resultDiv.className = 'alert alert-info';
            resultDiv.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Sending test email...';
            
            fetch('/test-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Email Sent!')) {
                    showTestResult('success', data);
                } else {
                    showTestResult('danger', data);
                }
            })
            .catch(error => {
                showTestResult('danger', 'Error sending test email: ' + error.message);
            });
        }
        
        // Show test result function
        function showTestResult(type, message) {
            const resultDiv = document.getElementById('testResult');
            resultDiv.style.display = 'block';
            resultDiv.className = `alert alert-${type}`;
            resultDiv.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" onclick="clearTestResult()">×</button>
            `;
        }
        
        // Clear test result function
        function clearTestResult() {
            const resultDiv = document.getElementById('testResult');
            resultDiv.style.display = 'none';
            resultDiv.innerHTML = '';
        }
        
        // OTP input formatting
        document.getElementById('otp')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>