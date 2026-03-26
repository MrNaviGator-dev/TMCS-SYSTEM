<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base target="_self">
    <title>TMCS Login - Member Portal</title>
    
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

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(0, 0, 0, 0.03);
            max-width: 400px;
            width: 100%;
            margin: 0 0.5rem;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%);
            color: white;
            padding: 1rem 0.75rem;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .card-header-custom h2 {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
        }

        .card-header-custom p {
            font-size: 0.75rem;
            margin-bottom: 0;
        }

        .user-type-selector {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .user-type-btn {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .user-type-btn:hover {
            border-color: #6c5ce7;
            background: #f8f9fa;
        }

        .user-type-btn.active {
            border-color: #6c5ce7;
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
        }

        .user-type-btn i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .user-type-btn small {
            font-size: 0.8rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.15);
            background: white;
            transform: translateY(-1px);
        }

        .input-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.2);
            transform: translateY(-2px);
        }

        .input-group-text {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            border: none;
            color: white;
            padding: 12px 16px;
            font-size: 1.1rem;
            border-right: 2px solid rgba(255,255,255,0.2);
        }

        .btn-outline-secondary {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: none;
            color: #6c5ce7;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
            transform: scale(1.05);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background: rgba(108, 92, 231, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .remember-me:hover {
            background: rgba(108, 92, 231, 0.1);
        }

        .remember-me input[type="checkbox"] {
            margin-right: 0.5rem;
            width: 18px;
            height: 18px;
            accent-color: #6c5ce7;
        }

        .btn-login {
            background: white;
            border: 2px solid #6c5ce7;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(108, 92, 231, 0.2);
            font-size: 0.8rem;
            width: 100%;
            color: #6c5ce7;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
            background: #f8f9fa;
            border-color: #5f3dc4;
            color: #5f3dc4;
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 0.5rem 0.7rem;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .divider {
            text-align: center;
            margin: 0.8rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
        }

        .divider span {
            background: white;
            padding: 0 0.6rem;
            color: #6c757d;
            font-size: 0.75rem;
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
            .login-container {
                padding: 0.25rem;
            }
            
            .login-card {
                margin: 0 0.25rem;
                border-radius: 10px;
            }
            
            .card-header-custom {
                padding: 0.75rem 0.5rem;
                border-radius: 10px 10px 0 0;
            }
            
            .card-header-custom h2 {
                font-size: 1rem;
            }
            
            .card-header-custom p {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card fade-in-up">
            <!-- Card Header -->
            <div class="card-header-custom">
                <i class="bi bi-mortarboard-fill fs-1 mb-3"></i>
                <h2 class="mb-3">TMCS Login Portal</h2>
                <p class="mb-0 opacity-90">Sign in with your phone number</p>
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

                <!-- Login Form -->
                <form method="POST" action="/login" id="loginForm" target="_self">
                    @csrf

                    <!-- Username Field -->
                    <div class="mb-4">
                        <label for="phone_number" class="form-label">
                            <i class="bi bi-person-fill me-2"></i>Username
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="phone_number" class="form-control" id="phone_number" 
                                   placeholder="Enter your phone number" required>
                        </div>
                        <small class="text-muted">Enter your registered phone number</small>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-shield-lock-fill me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" name="password" class="form-control" id="password" 
                                   placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        <small class="text-muted">Enter your secure password</small>
                    </div>

                    <!-- Remember Me -->
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember" class="form-check-label">
                            Remember me 
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-login mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                    
                    <!-- Forgot Password Link -->
                    <div class="text-center mb-3">
                        <a href="/forgot-password" class="text-decoration-none" style="color: #6c5ce7; font-size: 0.9rem;">
                            <i class="bi bi-key me-1"></i>Forgot Password?
                        </a>
                    </div>
                </form>

                <!-- Divider -->
                <!-- <div class="divider"> -->
                    
                
                <!-- <span>New to TMCS?</span> -->
                <!-- </div> -->

                <!-- Register Link -->
                <div class="text-center">
                    <p class="mb-0">
                        Don't have an account? 
                        <a href="/register" class="text-decoration-none fw-bold" style="color: #6c5ce7;">
                            Register here
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
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const loginForm = document.getElementById('loginForm');

            // Toggle password visibility
            togglePasswordBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle eye icon
                if (type === 'text') {
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            });

            // Ensure form submits in same tab
            loginForm.addEventListener('submit', function(e) {
                console.log('Login form submitting...');
                // Force submission in same window
                this.target = '_self';
                console.log('Form target set to:', this.target);
            });
        });
    </script>
</body>
</html>
