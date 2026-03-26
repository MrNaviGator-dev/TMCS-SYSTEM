<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMCS Member Registration</title>
    
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

        .registration-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .registration-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(0, 0, 0, 0.03);
            max-width: 700px;
            width: 100%;
            margin: 0 1rem;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%);
            color: white;
            padding: 1.5rem 1rem;
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

        .btn-register {
            background: white;
            border: 2px solid #6c5ce7;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(108, 92, 231, 0.2);
            font-size: 0.9rem;
            color: #6c5ce7;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
            background: #f8f9fa;
            border-color: #5f3dc4;
            color: #5f3dc4;
        }

        .profile-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            background: #fafbfc;
            cursor: pointer;
        }

        .profile-upload-area:hover {
            border-color: #6c5ce7;
            background: #f8f9fa;
        }

        .profile-upload-area.dragover {
            border-color: #00b894;
            background: #f0fff4;
        }

        .preview-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #6c5ce7;
            margin: 0 auto 0.5rem;
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 0.75rem 1rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .section-title {
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.3rem;
            border-bottom: 2px solid #6c5ce7;
            font-size: 1.1rem;
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
            .registration-container {
                padding: 0.5rem;
            }
            
            .registration-card {
                margin: 0 0.5rem;
                border-radius: 10px;
            }
            
            .card-header-custom {
                padding: 1rem 0.75rem;
                border-radius: 10px 10px 0 0;
            }
            
            .card-header-custom h2 {
                font-size: 1.3rem;
            }
            
            .card-header-custom p {
                font-size: 0.8rem;
            }
            
            .card-body {
                padding: 1rem !important;
            }
            
            .section-title {
                font-size: 1rem;
                margin-bottom: 0.8rem;
            }
            
            .form-control {
                font-size: 0.9rem;
                padding: 0.5rem;
            }
            
            .btn-register {
                padding: 10px 20px;
                font-size: 0.8rem;
            }
            
            .profile-upload-area {
                padding: 0.75rem;
            }
            
            .preview-image {
                width: 50px;
                height: 50px;
            }
            
            .col-md-4,
            .col-md-6,
            .col-md-8,
            .col-md-12 {
                margin-bottom: 1rem !important;
            }
        }

        /* Tablet Responsive */
        @media (min-width: 769px) and (max-width: 1024px) {
            .registration-card {
                max-width: 650px;
            }
            
            .card-header-custom {
                padding: 1.25rem 1.5rem;
            }
            
            .card-body {
                padding: 1.5rem 2rem !important;
            }
        }

        /* Large Desktop */
        @media (min-width: 1025px) {
            .registration-card {
                max-width: 700px;
            }
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="registration-card fade-in-up">
            <!-- Card Header -->
            <div class="card-header-custom">
                <i class="bi bi-mortarboard-fill fs-1 mb-3"></i>
                <h2 class="mb-3">TMCS Member Registration</h2>
                <p class="mb-0 opacity-90">Join our community of dedicated members</p>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3 p-lg-4">
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

                <!-- Registration Form -->
                <form method="POST" action="/register" enctype="multipart/form-data" id="registrationForm">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 class="section-title">
                                <i class="bi bi-person-fill me-2"></i>Personal Information
                            </h5>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" id="name" 
                                   placeholder="Enter your full name" required>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="registration_number" class="form-label">Registration Number <small class="text-muted">(Optional)</small></label>
                            <input type="text" name="registration_number" class="form-control" id="registration_number" 
                                   placeholder="e.g., TMCS/2024/001">
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 class="section-title">
                                <i class="bi bi-telephone-fill me-2"></i>Contact Information
                            </h5>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" 
                                   placeholder="your.email@example.com" required>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <input type="tel" name="phone_number" class="form-control" id="phone_number" 
                                       placeholder="255716294829" required>
                            </div>
                            <!-- <small class="text-muted">Format: 255716294829 (no + sign)</small> -->
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 class="section-title">
                                <i class="bi bi-geo-alt-fill me-2"></i>Additional Information
                            </h5>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="home_diocese" class="form-label">Home Diocese</label>
                            <input type="text" name="home_diocese" class="form-control" id="home_diocese" 
                                   placeholder="Enter your home diocese" required>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" class="form-select" id="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="year_of_study" class="form-label">Year of Study</label>
                            <select name="year_of_study" class="form-select" id="year_of_study">
                                <option value="">Select Year</option>
                                <option value="Year 1">Year 1</option>
                                <option value="Year 2">Year 2</option>
                                <option value="Year 3">Year 3</option>
                                <option value="Year 4">Year 4</option>
                                <option value="Year 5">Year 5</option>
                                <option value="Graduate">Graduate</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                    </div>

                    <!-- Profile Picture Section -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 class="section-title">
                                <i class="bi bi-camera-fill me-2"></i>Profile Picture
                            </h5>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="profile-section text-center">
                                <div class="profile-upload-area" id="dropZone">
                                    <div id="previewContainer">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px; margin: 0 auto;">
                                            <i class="bi bi-cloud-upload fs-4 text-muted"></i>
                                        </div>
                                        <h6 class="text-muted small">Drag & Drop your photo</h6>
                                        <p class="text-muted small">or click to browse</p>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="chooseFileBtn">
                                            <i class="bi bi-folder2-open me-1"></i>Choose File
                                        </button>
                                        <p class="text-muted mt-1 mb-0 small">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                    <img id="previewImage" class="img-fluid rounded-circle d-none" style="max-width: 80px; height: 80px; object-fit: cover;" alt="Profile Preview">
                                </div>
                                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="d-none">
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="d-flex align-items-center h-100">
                                <div class="text-muted">
                                    <p class="mb-2"><i class="bi bi-info-circle me-2"></i>Upload a recent photo of yourself (optional)</p>
                                    <ul class="small mb-0">
                                        <li>Clear, recent photo recommended</li>
                                        <li>Face should be clearly visible</li>
                                        <li>Professional appearance preferred</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 class="section-title">
                                <i class="bi bi-lock-fill me-2"></i>Security
                            </h5>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" 
                                   placeholder="Create a password" required>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" 
                                   placeholder="Confirm your password" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-register">
                            <i class="bi bi-person-plus-fill me-2"></i>Complete Registration
                        </button>
                    </div>
                </form>
                
                <!-- Sign In Link -->
                <div class="text-center mt-4">
                    <p class="mb-0">
                        Already have an account? 
                        <a href="/login" class="text-decoration-none fw-bold" style="color: #6c5ce7;">
                            Sign In
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
            const fileInput = document.getElementById('profile_picture');
            const dropZone = document.getElementById('dropZone');
            const chooseFileBtn = document.getElementById('chooseFileBtn');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');

            // File upload handlers
            chooseFileBtn.addEventListener('click', () => fileInput.click());
            
            fileInput.addEventListener('change', function(e) {
                handleFile(e.target.files[0]);
            });

            // Drag and drop handlers
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFile(files[0]);
                }
            });

            function handleFile(file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('d-none');
                    previewContainer.classList.add('d-none');
                    
                    // Update drop zone
                    dropZone.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded-circle mb-2" style="max-width: 80px; height: 80px; object-fit: cover;" alt="Profile Preview">
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" id="removeFileBtn">
                                <i class="bi bi-trash me-1"></i>Remove Photo
                            </button>
                        </div>
                    `;
                    
                    // Re-attach remove button handler
                    document.getElementById('removeFileBtn').addEventListener('click', function() {
                        resetFileUpload();
                    });
                };
                reader.readAsDataURL(file);
            }

            function resetFileUpload() {
                fileInput.value = '';
                previewImage.classList.add('d-none');
                previewContainer.classList.remove('d-none');
                dropZone.innerHTML = `
                    <div id="previewContainer">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px; margin: 0 auto;">
                            <i class="bi bi-cloud-upload fs-4 text-muted"></i>
                        </div>
                        <h6 class="text-muted small">Drag & Drop your photo</h6>
                        <p class="text-muted small">or click to browse</p>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="chooseFileBtn">
                            <i class="bi bi-folder2-open me-1"></i>Choose File
                        </button>
                        <p class="text-muted mt-1 mb-0 small">PNG, JPG, GIF up to 2MB</p>
                    </div>
                `;
                
                // Re-attach choose file button handler
                document.getElementById('chooseFileBtn').addEventListener('click', () => fileInput.click());
            }

            // Phone number formatting
            const phoneInput = document.getElementById('phone_number');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                if (!value.startsWith('255')) {
                    if (value.startsWith('0')) {
                        value = '255' + value.substring(1);
                    } else if (!value.startsWith('2')) {
                        value = '255' + value;
                    }
                }
                e.target.value = value;
            });
        });
    </script>
</body>
</html>
