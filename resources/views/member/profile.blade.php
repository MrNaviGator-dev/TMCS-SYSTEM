<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - TMCS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-toggle {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .profile-toggle:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
        }

        .profile-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .profile-container {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #4a69bd, #6c5ce7, #a29bfe);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #6c5ce7;
            margin-bottom: 1rem;
        }

        .profile-avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 1rem;
            border: 4px solid #6c5ce7;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            color: #6c5ce7;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .form-control:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.15);
        }

        .btn-update {
            background: white;
            border: 2px solid #6c5ce7;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(108, 92, 231, 0.1);
            font-size: 0.9rem;
            color: #6c5ce7;
        }

        .btn-update:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.2);
            background: #f8f9fa;
            color: #5f3dc4;
            border-color: #5f3dc4;
        }

        .btn-back {
            background: white;
            border: 2px solid #6c5ce7;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(108, 92, 231, 0.1);
            font-size: 0.9rem;
            color: #6c5ce7;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.2);
            background: #f8f9fa;
            color: #5f3dc4;
            text-decoration: none;
            border-color: #5f3dc4;
        }

        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .profile-picture-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .upload-btn {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 2px dashed #6c5ce7;
            border-radius: 15px;
            padding: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
            border-color: #5f3dc4;
        }

        .upload-btn i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem;
            }
            
            .profile-card {
                padding: 1.5rem;
            }
            
            .profile-avatar {
                width: 100px;
                height: 100px;
            }
            
            .profile-avatar-placeholder {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }
            
            .profile-name {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="/member/dashboard">
                <i class="bi bi-mortarboard-fill me-2"></i>TMCS Member
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown profile-dropdown">
                        <a class="nav-link profile-toggle dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->profile_picture)
                                <img src="/uploads/profiles/{{ auth()->user()->profile_picture }}" 
                                     alt="Profile" class="profile-img"
                                     onerror="console.log('Image failed to load: /uploads/profiles/{{ auth()->user()->profile_picture }}'); this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiNmOGY5ZmEiLz4KPHBhdGggZD0iTTIwIDIwQzIyLjIwOTEgMjAgMjQgMTcuMjA5MSAyNCAxNUMyNCAxMi43OTA5IDIyLjIwOTEgMTAgMjAgMTBDMTcuNzA5MSAxMCAxNiAxMi43OTA5IDE2IDE1QzE2IDE3LjIwOTEgMTcuNzA5MSAyMCAyMCAyMFoiIGZpbGw9IiM2YzVjZTciLz4KPGNpcmNsZSBjeD0iMjAiIGN5PSIzMCIgcj0iOCIgZmlsbD0iIzZjNWNlNyIvPgo8L3N2Zz4K';">
                            @else
                                <div class="profile-img d-flex align-items-center justify-content-center bg-white text-primary">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif
                            <span>{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/member/profile">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Profile Content -->
    <div class="profile-container">
        <div class="profile-card">
            <!-- Profile Header -->
            <div class="profile-header">
                @if(auth()->user()->profile_picture)
                    <img src="/uploads/profiles/{{ auth()->user()->profile_picture }}" 
                         alt="Profile" class="profile-avatar" id="currentProfilePic"
                         onerror="console.log('Profile image failed to load: /uploads/profiles/{{ auth()->user()->profile_picture }}'); this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjYwIiBjeT0iNjAiIHI9IjYwIiBmaWxsPSIjZjhmOWZhIi8+CjxwYXRoIGQ9Ik02MCA2MEM2Ni42Mjc0IDYwIDcyIDU0LjYyNzQgNzIgNDhDNzIgNDEuMzcyNyA2Ni42Mjc0IDM2IDYwIDM2QzUzLjM3MjYgMzYgNDggNDEuMzcyNyA0OCA0OEM0OCA1NC42Mjc0IDUzLjM3MjYgNjAgNjAgNjBaIiBmaWxsPSIjNmM1Y2U3Ii8+CjxjaXJjbGUgY3g9IjYwIiBjeT0iOTAiIHI9IjI0IiBmaWxsPSIjNmM1Y2U3Ii8+Cjwvc3ZnPgo=';">
                @else
                    <div class="profile-avatar-placeholder">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
                <div class="profile-info">
                    <h2>{{ auth()->user()->name }}</h2>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                    <span class="badge bg-primary">{{ auth()->user()->role ?? 'Member' }}</span>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-custom mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-custom mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-warning alert-custom mb-4">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Update Form -->
            <form method="POST" action="/member/profile" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Picture Section -->
                <div class="profile-picture-section">
                    <label class="upload-btn" for="profile_picture">
                        <i class="bi bi-camera"></i>
                        <div class="fw-bold">Click to upload new photo</div>
                        <small class="text-muted">JPG, PNG or GIF (Max 2MB)</small>
                    </label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="d-none">
                </div>

                <!-- Personal Information -->
                <div class="row mb-3">
                    <div class="col-md-12 mb-2">
                        <label for="name" class="form-label"><strong>Full Name</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="name" class="form-control" id="name" 
                                   value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <small class="text-muted">Name cannot be changed</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 mb-2">
                        <label for="phone_number" class="form-label"><strong>Phone Number</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <input type="tel" name="phone_number" class="form-control" id="phone_number" 
                                   value="{{ auth()->user()->phone_number }}" required>
                        </div>
                        <small class="text-muted">Update your phone number</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 mb-2">
                        <label for="email" class="form-label"><strong>Email Address</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control" id="email" 
                                   value="{{ auth()->user()->email }}" readonly>
                        </div>
                        <small class="text-muted">Email cannot be changed</small>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label for="gender" class="form-label"><strong>Gender</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-gender"></i>
                            </span>
                            <select name="gender" class="form-select" id="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ auth()->user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ auth()->user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ auth()->user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <small class="text-muted">Select your gender</small>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label for="year_of_study" class="form-label"><strong>Year of Study</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-book"></i>
                            </span>
                            <select name="year_of_study" class="form-select" id="year_of_study">
                                <option value="">Select Year</option>
                                <option value="Year 1" {{ auth()->user()->year_of_study == 'Year 1' ? 'selected' : '' }}>Year 1</option>
                                <option value="Year 2" {{ auth()->user()->year_of_study == 'Year 2' ? 'selected' : '' }}>Year 2</option>
                                <option value="Year 3" {{ auth()->user()->year_of_study == 'Year 3' ? 'selected' : '' }}>Year 3</option>
                                <option value="Year 4" {{ auth()->user()->year_of_study == 'Year 4' ? 'selected' : '' }}>Year 4</option>
                                <option value="Year 5" {{ auth()->user()->year_of_study == 'Year 5' ? 'selected' : '' }}>Year 5</option>
                                <option value="Graduate" {{ auth()->user()->year_of_study == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                            </select>
                        </div>
                        <small class="text-muted">Select your current year of study</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label for="registration_number" class="form-label"><strong>Registration Number</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-card-text"></i>
                            </span>
                            <input type="text" name="registration_number" class="form-control" id="registration_number" 
                                   value="{{ auth()->user()->registration_number }}" readonly>
                        </div>
                        <small class="text-muted">Registration number cannot be changed</small>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label for="home_diocese" class="form-label"><strong>Home Diocese</strong></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-church"></i>
                            </span>
                            <input type="text" name="home_diocese" class="form-control" id="home_diocese" 
                                   value="{{ auth()->user()->home_diocese }}" readonly>
                        </div>
                        <small class="text-muted">Diocese cannot be changed</small>
                    </div>
                </div>

      
                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="/member/dashboard" class="btn-back me-3">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <button type="submit" class="btn btn-update">
                        <i class="bi bi-person-check me-2"></i>Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Logout Form (Hidden) -->
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profilePictureInput = document.getElementById('profile_picture');
            const uploadBtn = document.querySelector('.upload-btn');
            
            // Preview profile picture on selection
            profilePictureInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Check file size (2MB max)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB');
                        e.target.value = '';
                        return;
                    }
                    
                    // Check file type
                    if (!file.type.match('image.*')) {
                        alert('Please select an image file');
                        e.target.value = '';
                        return;
                    }
                    
                    // Preview the image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const currentPic = document.getElementById('currentProfilePic');
                        if (currentPic) {
                            currentPic.src = e.target.result;
                        } else {
                            // If no current picture, create one
                            const avatarPlaceholder = document.querySelector('.profile-avatar-placeholder');
                            if (avatarPlaceholder) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.alt = 'Profile';
                                img.className = 'profile-avatar';
                                img.id = 'currentProfilePic';
                                avatarPlaceholder.parentNode.replaceChild(img, avatarPlaceholder);
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                    
                    // Update upload button text
                    uploadBtn.innerHTML = `
                        <i class="bi bi-check-circle"></i>
                        <div class="fw-bold">File selected: ${file.name}</div>
                        <small class="text-muted">Click to change photo</small>
                    `;
                }
            });
        });
    </script>
</body>
</html>
