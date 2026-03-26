<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - TMCS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #fafafa 0%, #e8eaf6 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .forgot-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .forgot-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(0, 0, 0, 0.03);
            max-width: 450px;
            width: 100%;
            margin: 0 1rem;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .card-header-custom h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .card-header-custom p {
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(108, 92, 231, 0.2);
            font-size: 0.9rem;
            width: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
            background: linear-gradient(135deg, #5f3dc4, #8b7ff7);
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .forgot-container {
                padding: 0.5rem;
            }
            
            .forgot-card {
                margin: 0 0.5rem;
                border-radius: 10px;
            }
            
            .card-header-custom {
                padding: 1.5rem 1rem;
                border-radius: 10px 10px 0 0;
            }
            
            .card-header-custom h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-card fade-in-up">
            <!-- Card Header -->
            <div class="card-header-custom">
                <i class="bi bi-key-fill fs-1 mb-3"></i>
                <h2 class="mb-3">Forgot Password</h2>
                <p class="mb-0 opacity-90">Reset your TMCS account password</p>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4 p-lg-5">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-custom mb-4 fade-in-up">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-custom mb-4 fade-in-up">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-warning alert-custom mb-4 fade-in-up">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Step 1: Phone Number Form -->
                <form method="POST" action="/forgot-password" id="phoneForm" @if(session('show_password_form')) style="display: none;" @endif>
                    @csrf

                    <!-- Phone Number Field -->
                    <div class="mb-4">
                        <label for="phone_number" class="form-label"><strong>Phone Number</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <input type="tel" name="phone_number" class="form-control" id="phone_number" 
                                   placeholder="255716294829" required>
                        </div>
                        <small class="text-muted">Enter the phone number you used to register</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit mb-3">
                        <i class="bi bi-search me-2"></i>Find Account
                    </button>
                </form>

                <!-- Step 2: Password Reset Form -->
                @if(session('show_password_form') || session('phone_number'))
                <form method="POST" action="/forgot-password" id="passwordForm" @if(!session('show_password_form')) style="display: none;" @endif>
                    @csrf
                    <input type="hidden" name="phone_number" value="{{ session('phone_number') ?? old('phone_number') }}">

                    <!-- User Info Display -->
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Account Found:</strong> {{ session('phone_number') ?? old('phone_number') }}
                    </div>

                    <!-- Security Question Field -->
                    <div class="mb-4">
                        <label for="security_answer" class="form-label"><strong>What is your home diocese?</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            <input type="text" name="security_answer" class="form-control" id="security_answer" 
                                   placeholder="Enter your home diocese" required>
                        </div>
                        <small class="text-muted">Answer the security question to verify your identity</small>
                    </div>

                    <!-- New Password Field -->
                    <div class="mb-4">
                        <label for="new_password" class="form-label"><strong>New Password</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="new_password" class="form-control" id="new_password" 
                                   placeholder="Enter new password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                <i class="bi bi-eye" id="newEyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label"><strong>Confirm New Password</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" 
                                   placeholder="Confirm new password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="bi bi-eye" id="confirmEyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit mb-3">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Password
                    </button>
                </form>
                @endif

                <!-- Back to Login -->
                <div class="text-center">
                    <p class="mb-0">
                        <a href="/login" class="text-decoration-none" style="color: #6c5ce7;">
                            <i class="bi bi-arrow-left me-1"></i>Back to Sign In
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleNewPasswordBtn = document.getElementById('toggleNewPassword');
            const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const newEyeIcon = document.getElementById('newEyeIcon');
            const confirmEyeIcon = document.getElementById('confirmEyeIcon');

            // Toggle new password visibility
            if (toggleNewPasswordBtn) {
                toggleNewPasswordBtn.addEventListener('click', function() {
                    const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    newPasswordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        newEyeIcon.classList.remove('bi-eye');
                        newEyeIcon.classList.add('bi-eye-slash');
                    } else {
                        newEyeIcon.classList.remove('bi-eye-slash');
                        newEyeIcon.classList.add('bi-eye');
                    }
                });
            }

            // Toggle confirm password visibility
            if (toggleConfirmPasswordBtn) {
                toggleConfirmPasswordBtn.addEventListener('click', function() {
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        confirmEyeIcon.classList.remove('bi-eye');
                        confirmEyeIcon.classList.add('bi-eye-slash');
                    } else {
                        confirmEyeIcon.classList.remove('bi-eye-slash');
                        confirmEyeIcon.classList.add('bi-eye');
                    }
                });
            }
        });
    </script>
</body>
</html>
