<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TMCS System')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- User ID for JavaScript -->
    @if(auth()->check())
        <meta name="user-id" content="{{ auth()->user()->id }}">
    @endif
    
    <!-- Cache Control Headers -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    @if(auth()->check())
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <i class="bi bi-mortarboard-fill me-2"></i>TMCS
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
                                         alt="Profile" class="profile-img">
                                @else
                                    <div class="profile-img d-flex align-items-center justify-content-center bg-white text-primary">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                                <span>{{ auth()->user()->name }}</span>
                                <i class="bi bi-chevron-down"></i>
                                @if(auth()->user()->role == 'admin')
                                    <span class="admin-badge">
                                        <i class="bi bi-shield-fill"></i>ADMIN
                                    </span>
                                @elseif(auth()->user()->role == 'leader')
                                    <span class="leader-badge">
                                        <i class="bi bi-shield-fill"></i>LEADER
                                    </span>
                                @endif
                            </a>
                            
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->role == 'admin')
                                    <li><a class="dropdown-item" href="#" onclick="console.log('Profile dropdown My Profile clicked'); window.location.href='/admin/dashboard#myProfile'; setTimeout(() => { console.log('Attempting to call showMyProfile'); if (typeof showMyProfile === 'function') { showMyProfile(); } else { console.log('showMyProfile function not found'); } }, 100); return false;">
                                        <i class="bi bi-person-circle me-2"></i>My Profile
                                    </a></li>
                                    <li><a class="dropdown-item" href="/admin/dashboard">
                                        <i class="bi bi-gear me-2"></i>Admin Dashboard
                                    </a></li>
                                @elseif(auth()->user()->role == 'leader')
                                    <li><a class="dropdown-item" href="/leader/dashboard">
                                        <i class="bi bi-shield me-2"></i>Leader Dashboard
                                    </a></li>
                                @else
                                    <li><a class="dropdown-item" href="/member/profile">
                                        <i class="bi bi-person me-2"></i>My Profile
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item logout" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Logout Form (Hidden) -->
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Session Validation Script -->
    <script>
        // Session Validation - Check if user is authenticated
        function checkSession() {
            // Determine the current user role and use appropriate endpoint
            let endpoint = '/member/check-session';
            if (window.location.pathname.includes('/admin/')) {
                endpoint = '/admin/check-session';
            } else if (window.location.pathname.includes('/leader/')) {
                endpoint = '/leader/check-session';
            }
            
            fetch(endpoint, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.authenticated) {
                    // User is not authenticated, redirect to login
                    window.location.href = '/login?error=Session expired. Please login again.';
                }
            })
            .catch(error => {
                console.error('Session check failed:', error);
                // If session check fails, redirect to login for safety
                window.location.href = '/login?error=Authentication error. Please login again.';
            });
        }

        // Check session immediately when page loads
        checkSession();

        // Check session periodically (every 30 seconds)
        setInterval(checkSession, 30000);

        // Check session when user interacts with the page
        document.addEventListener('click', function(event) {
            // Only check for clicks on dashboard elements, not external links
            if (event.target.closest('a')?.href?.includes('/logout')) {
                return; // Allow logout
            }
            checkSession();
        });
    </script>
    
    @stack('scripts')
    
    <style>
        /* Common Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #ffffff !important;
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
            border: 2px solid #fff;
        }

        .admin-badge {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-left: 0.5rem;
        }

        .leader-badge {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-left: 0.5rem;
        }

        .dropdown-item {
            color: #2d3436;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0.25rem 0.5rem;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(5px);
        }

        .dropdown-item.logout {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            font-weight: 600;
        }

        .dropdown-item.logout:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateX(5px);
        }

        .main-content {
            padding: 2rem 0;
        }

        /* Flash Messages */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeeba);
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem 0;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .profile-toggle {
                padding: 0.3rem 0.8rem;
                font-size: 0.9rem;
            }
            
            .profile-img {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</body>
</html>
