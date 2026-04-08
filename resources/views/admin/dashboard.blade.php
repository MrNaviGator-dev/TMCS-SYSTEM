@extends('layouts.app')

@section('content')
<!-- Mobile Navbar -->
<nav class="navbar navbar-dark bg-dark d-md-none fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="bi bi-shield-check me-2"></i>Admin Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminSidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<style>
/* Mobile Navbar Styles */
@media (max-width: 767px) {
    .navbar {
        padding: 0.5rem 1rem !important;
        z-index: 1060 !important;
    }
    
    .navbar-brand {
        font-size: 1rem !important;
        padding: 0.25rem 0 !important;
    }
    
    .navbar-toggler {
        position: absolute !important;
        top: 0.5rem !important;
        left: 0.5rem !important;
        padding: 0.25rem 0.5rem !important;
        border: none !important;
        border-radius: 0.25rem !important;
        z-index: 1061 !important;
    }
    
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        width: 24px !important;
        height: 24px !important;
    }
}

/* Mobile Sidebar Styles */
@media (max-width: 767px) {
    #adminSidebarMenu {
        position: fixed;
        top: 56px;
        left: 0;
        width: 280px;
        height: calc(100vh - 56px);
        background: #212529 !important;
        z-index: 1050;
        box-shadow: 2px 0 10px rgba(0,0,0,0.3);
        overflow-y: auto;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
    }
    
    #adminSidebarMenu.show {
        transform: translateX(0);
    }
    
    #adminSidebarMenu.collapse:not(.show) {
        display: block;
        transform: translateX(-100%);
    }
}

@media (min-width: 768px) {
    #adminSidebarMenu.collapse {
        display: none !important;
    }
}

/* Manage Users Responsive Styles */
@media (max-width: 767px) {
    /* Statistics Cards - 2x2 grid on mobile */
    #manageUsersSection .row.mb-4 .col-md-3 {
        flex: 0 0 50%;
        max-width: 50%;
        margin-bottom: 1rem;
    }
    
    /* Search and Filter - Stack vertically on mobile */
    #manageUsersSection .row.mb-4:nth-child(2) .col-md-8,
    #manageUsersSection .row.mb-4:nth-child(2) .col-md-2 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 0.5rem;
    }
    
    /* Bulk Actions Bar - Stack on mobile */
    #manageUsersSection .bulk-actions-bar .d-flex {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start !important;
    }
    
    #manageUsersSection .bulk-actions-bar .d-flex.gap-2 {
        flex-wrap: wrap;
        width: 100%;
    }
    
    #manageUsersSection .bulk-actions-bar .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Table Responsive */
    #manageUsersSection .table-responsive {
        font-size: 0.8rem;
    }
    
    #manageUsersSection .table th,
    #manageUsersSection .table td {
        padding: 0.5rem 0.25rem;
        white-space: nowrap;
    }
    
    /* Hide some columns on very small screens */
    @media (max-width: 480px) {
        #manageUsersSection .table th:nth-child(4),
        #manageUsersSection .table td:nth-child(4),
        #manageUsersSection .table th:nth-child(9),
        #manageUsersSection .table td:nth-child(9) {
            display: none;
        }
        
        /* Statistics Cards - Single column on very small screens */
        #manageUsersSection .row.mb-4 .col-md-3 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    
    /* Action buttons responsive */
    #manageUsersSection .action-buttons {
        display: flex;
        gap: 0.25rem;
    }
    
    #manageUsersSection .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }
}

/* Modal Size Controls */
.modal-dialog {
    max-width: 90vw;
    max-height: 90vh;
}

.modal-dialog.modal-lg {
    max-width: 800px;
    max-height: 85vh;
}

.modal-dialog.modal-lg .modal-content {
    max-height: 85vh;
    overflow-y: auto;
}

.modal-body {
    max-height: 60vh;
    overflow-y: auto;
}

/* Specific modal size fixes */
#userDetailsModal .modal-dialog {
    max-width: 600px;
}

#editUserModal .modal-dialog {
    max-width: 700px;
}

#editProfileModal .modal-dialog {
    max-width: 650px;
}

/* Leader modals */
#leaderDetailsModal .modal-dialog,
#editLeaderModal .modal-dialog {
    max-width: 700px;
}

/* Manage Leaders Responsive Styles */
@media (max-width: 767px) {
    /* Leadership Statistics Cards - Responsive layout on mobile */
    #manageLeadersSection .row.mb-4 .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
        margin-bottom: 1rem;
        padding: 0 0.5rem;
    }
    
    /* Leaders Table Responsive */
    #manageLeadersSection .table-responsive {
        font-size: 0.8rem;
    }
    
    #manageLeadersSection .table th,
    #manageLeadersSection .table td {
        padding: 0.5rem 0.25rem;
        white-space: nowrap;
    }
    
    /* Hide some columns on very small screens */
    @media (max-width: 480px) {
        #manageLeadersSection .table th:nth-child(3),
        #manageLeadersSection .table td:nth-child(3),
        #manageLeadersSection .table th:nth-child(7),
        #manageLeadersSection .table td:nth-child(7) {
            display: none;
        }
        
        /* Leadership Statistics Cards - Single column on very small screens */
        #manageLeadersSection .row.mb-4 .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 1rem;
        }
    }
}

/* Member Payments Responsive Styles */
@media (max-width: 767px) {
    /* Payment Statistics Cards - Responsive layout on mobile */
    #memberPaymentsSection .row.mb-4 .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
        margin-bottom: 1rem;
        padding: 0 0.5rem;
    }
    
    /* Filter Dropdowns - Stack vertically on mobile */
    #memberPaymentsSection .row.mb-4:nth-child(2) .col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 0.5rem;
    }
    
    /* Payment List Responsive */
    #memberPaymentsSection .card-body {
        padding: 1rem;
    }
    
    #memberPaymentsSection .card-title {
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    #memberPaymentsSection h3 {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    /* Custom Payment Table Responsive */
    #memberPaymentsSection .admin-payment-row {
        border-bottom: 1px solid #dee2e6 !important;
        padding: 1rem 0.5rem !important;
    }
    
    #memberPaymentsSection .admin-payment-row .col-md-1,
    #memberPaymentsSection .admin-payment-row .col-md-2 {
        margin-bottom: 0.5rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Action buttons responsive */
    #memberPaymentsSection .admin-payment-actions {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        align-items: center;
    }
    
    #memberPaymentsSection .admin-payment-actions .btn-sm {
        width: 100%;
        max-width: 120px;
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
    
    /* Payment type items responsive */
    #memberPaymentsSection .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    #memberPaymentsSection .d-flex.justify-content-between .badge {
        align-self: flex-end;
    }
    
    /* Hide less important columns on very small screens */
    @media (max-width: 480px) {
        /* Payment Statistics Cards - Single column on very small screens */
        #memberPaymentsSection .row.mb-4 .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 1rem;
        }
        
        /* Larger text on very small screens */
        #memberPaymentsSection .card-title {
            font-size: 1rem;
        }
        
        #memberPaymentsSection h3 {
            font-size: 1.8rem;
        }
        
        /* Custom Payment Table - Stack columns on very small screens */
        #memberPaymentsSection .admin-payment-row {
            padding: 1rem 0.25rem !important;
        }
        
        #memberPaymentsSection .admin-payment-row .col-md-1,
        #memberPaymentsSection .admin-payment-row .col-md-2 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0.5rem 0.25rem;
            margin-bottom: 0.75rem;
        }
        
        /* Hide Email & Phone column on very small screens */
        #memberPaymentsSection .admin-payment-row .col-md-2:nth-child(3) {
            display: none;
        }
        
        /* Optimize S/NO column */
        #memberPaymentsSection .admin-payment-row .col-md-1:first-child {
            text-align: left;
            padding: 0.25rem;
        }
        
        /* Better spacing for payment details */
        #memberPaymentsSection .admin-payment-row .small {
            font-size: 0.75rem;
            line-height: 1.3;
        }
        
        /* Action buttons - full width on very small screens */
        #memberPaymentsSection .admin-payment-actions {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
        }
        
        #memberPaymentsSection .admin-payment-actions .btn-sm {
            width: auto;
            min-width: 80px;
            max-width: none;
            flex: 1;
        }
        
        /* Payment type items - better layout */
        #memberPaymentsSection .d-flex.justify-content-between {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
        }
        
        #memberPaymentsSection .d-flex.justify-content-between .badge {
            align-self: center;
            margin-top: 0.25rem;
        }
    }
}
</style>

<!-- Mobile Sidebar -->
<div class="collapse d-md-none" id="adminSidebarMenu">
    <div class="bg-dark p-3">
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showMyProfile()">
                <i class="bi bi-person-circle me-2"></i>Personal Informations
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showManageUsers()">
                <i class="bi bi-people-fill me-2"></i>Manage Users
            </a>
            <button class="list-group-item list-group-item-action bg-dark text-white" onclick="showAddMemberForm()">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Member
            </button>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showManageLeaders()">
                <i class="bi bi-person-badge-fill me-2"></i>Manage Leaders
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showMakePayments()">
                <i class="bi bi-cash-coin me-2"></i>Make Payments
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showAnnouncements()">
                <i class="bi bi-megaphone-fill me-2"></i>Announcements
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showPaymentAccounts()">
                <i class="bi bi-credit-card-fill me-2"></i>Payment Accounts
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showMemberPayments()">
                <i class="bi bi-cash-stack me-2"></i>Member Payments
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" onclick="showReports()">
                <i class="bi bi-graph-up me-2"></i>Reports
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action bg-dark text-white text-danger w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid py-4" style="padding-top: 56px;">
    @php
    // Fetch all users once at the top (excluding user ID 16) - ordered from first to last
    $allUsers = DB::table('users')->where('id', '!=', 16)->orderBy('id', 'asc')->get();
    @endphp
    
    <div class="row">
        <!-- Left Sidebar - Admin Menu -->
        <div class="col-md-3 d-none d-md-block">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-list me-2"></i>Admin Menu
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        
                        <a href="#" class="list-group-item list-group-item-action" onclick="showMyProfile()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-person-circle me-2"></i>Personal Informations
                        </a>
                           <!-- Other Admin Functions -->
                           <a href="#" class="list-group-item list-group-item-action" onclick="showManageUsers()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-people-fill me-2"></i>Manage Users
                        </a>
                        <!-- Divider -->
                        <div class="dropdown-divider"></div>
                        
                        <!-- Add New Member Button -->
                        <button class="list-group-item list-group-item-action" onclick="showAddMemberForm()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-person-plus-fill me-2"></i>Add New Member
                        </button>
                        
                     
                        <a href="#" class="list-group-item list-group-item-action" onclick="showManageLeaders()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-person-badge-fill me-2"></i>Manage Leaders
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showMakePayments()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-cash-coin me-2"></i>Make Payments
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showAnnouncements()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-megaphone-fill me-2"></i>Announcements
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showPaymentAccounts()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-credit-card-fill me-2"></i>Payment Accounts
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showMemberPayments()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-cash-stack me-2"></i>Member Payments
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="showReports()" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                            <i class="bi bi-graph-up me-2"></i>Reports
                        </a>
                        <!-- Divider -->
                        <div class="dropdown-divider"></div>
                        
                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="list-group-item list-group-item-action text-danger w-100 text-start border-0 bg-transparent" style="font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 400; letter-spacing: 0.4px; font-size: 0.9rem;">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            <!-- Add New Member Form (Initially Hidden) -->
            <div id="addMemberForm" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-people-fill me-2"></i>Manage Users
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="/admin/members/store" enctype="multipart/form-data" id="addMemberForm">
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
                                
                                <div class="col-md-6">
                                    <div class="profile-upload-area" id="dropZone">
                                        <div id="previewContainer">
                                            <i class="bi bi-cloud-upload fs-3 text-muted mb-2"></i>
                                            <h6 class="small">Drag & Drop photo</h6>
                                            <p class="text-muted mb-2 small">or</p>
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="chooseFileBtn">
                                                <i class="bi bi-folder2-open me-1"></i>Choose File
                                            </button>
                                        </div>
                                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;">
                                    </div>
                                    <small class="text-muted">Allowed formats: JPG, PNG, GIF. Max size: 2MB</small>
                                </div>
                            </div>

                            <!-- Account Information Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h5 class="section-title">
                                        <i class="bi bi-shield-lock me-2"></i>Account Information
                                    </h5>
                                </div>
                                 
                                <div class="col-md-6 mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" required 
                                           placeholder="Enter password">
                                </div>
                                 
                                <div class="col-md-6 mb-2">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required 
                                           placeholder="Confirm password">
                                </div>
                                 
                                <div class="col-md-6 mb-2">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" class="form-select" id="role" required>
                                        <option value="">Select Role</option>
                                        <option value="member">Member</option>
                                        <option value="leader">Leader</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                 
                                <div class="col-md-6 mb-2">
                                    <label for="membership_status" class="form-label">Membership Status</label>
                                    <select name="membership_status" class="form-select" id="membership_status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                             
                            <!-- Submit Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-danger">
                                            <i class="bi bi-x-circle me-2"></i>Clear
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-person-plus me-2"></i>Add TMCS Member
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Manage Users Section (Initially Visible) -->
            <div id="manageUsersSection" class="content-section">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-people-fill me-2"></i>Manage Users
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $allUsers->count() }}</h4>
                                                <small>Total Users</small>
                                            </div>
                                            <i class="bi bi-people fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $allUsers->where('membership_status', 'Active')->count() }}</h4>
                                                <small>Active</small>
                                            </div>
                                            <i class="bi bi-check-circle fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $allUsers->where('membership_status', 'Pending')->count() }}</h4>
                                                <small>Pending</small>
                                            </div>
                                            <i class="bi bi-clock-history fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $allUsers->where('membership_status', 'Inactive')->count() }}</h4>
                                                <small>Inactive</small>
                                            </div>
                                            <i class="bi bi-x-circle fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search and Filter -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="searchManageUsers" placeholder="Search users by name, email, phone, or gender...">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="roleManageFilter">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="leader">Leader</option>
                                    <option value="member">Member</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="statusManageFilter">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bulk Actions Bar -->
                        <div class="bulk-actions-bar d-none mb-3" id="bulkActionsBar">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted">Selected: <strong id="selectedCount">0</strong> users</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-success" id="bulkApproveBtn">
                                        <i class="bi bi-check-circle me-1"></i>Approve Selected
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" id="bulkRejectBtn">
                                        <i class="bi bi-x-circle me-1"></i>Reject Selected
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn">
                                        <i class="bi bi-trash me-1"></i>Delete Selected
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary" id="clearSelectionBtn">
                                        <i class="bi bi-x-lg me-1"></i>Clear Selection
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Users Management Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-sm compact-table" id="manageUsersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="30px">
                                            <input type="checkbox" class="form-check-input" id="selectAllCheckbox">
                                        </th>
                                        <th width="80px">ID</th>
                                        <th width="180px">Name</th>
                                        <th width="220px">Email</th>
                                        <th width="130px">Phone</th>
                                        <th width="70px">Gender</th>
                                        <th width="80px">Role</th>
                                        <th width="80px">Status</th>
                                        <th width="90px">Joined</th>
                                        <th width="100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allUsers as $user)
                                    <tr data-user-id="{{ $user->id }}" class="user-row">
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                                        </td>
                                        <td>
                                            <span class="user-id">TMCS-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td>
                                            <span class="user-name" title="{{ $user->name }}">{{ $user->name }}</span>
                                        </td>
                                        <td>
                                            <span class="user-email" title="{{ $user->email }}">{{ $user->email }}</span>
                                        </td>
                                        <td>
                                            <span class="user-phone">{{ $user->phone_number ?: 'Not set' }}</span>
                                        </td>
                                        <td>
                                            <span class="user-gender">{{ $user->gender ?: 'Not set' }}</span>
                                        </td>
                                        <td>
                                            <span class="role-badge role-{{ $user->role }}">
                                                {{ $user->role == 'admin' ? 'Admin' : ($user->role == 'leader' ? 'Leader' : 'Member') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(($user->membership_status ?? 'Active') == 'Pending')
                                                <div class="status-pending">
                                                    <span class="badge bg-warning badge-sm">Pending</span>
                                                    <div class="status-actions">
                                                        <button class="btn btn-success btn-xs" onclick="approveUser({{ $user->id }}, '{{ $user->name }}')" title="Approve">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-xs" onclick="rejectUser({{ $user->id }}, '{{ $user->name }}')" title="Reject">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge bg-{{ ($user->membership_status ?? 'Active') == 'Active' ? 'success' : 'secondary' }} badge-sm">
                                                    {{ $user->membership_status ?? 'Active' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="user-joined">{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-outline-primary btn-xs" onclick="viewUserDetails({{ $user->id }})" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-warning btn-xs" onclick="editUserDetails({{ $user->id }})" title="Edit User">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-xs" onclick="deleteUserConfirm({{ $user->id }}, '{{ $user->name }}')" title="Delete User">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <style>
                        .compact-table {
                            font-size: 0.85rem;
                        }
                        
                        .compact-table th,
                        .compact-table td {
                            padding: 0.5rem 0.75rem;
                            vertical-align: middle;
                            white-space: nowrap;
                            overflow: hidden;
                        }
                        
                        .user-row {
                            height: 45px;
                        }
                        
                        .user-id {
                            font-size: 0.75rem;
                            font-weight: 600;
                            color: #6c757d;
                        }
                        
                        .user-name {
                            font-weight: 500;
                            display: block;
                            max-width: 160px;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                        }
                        
                        .user-email {
                            font-size: 0.8rem;
                            color: #6c757d;
                            display: block;
                            max-width: 200px;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                        }
                        
                        .user-phone {
                            font-size: 0.8rem;
                            display: block;
                        }

                        
                        
                        .user-gender {
                            font-size: 0.8rem;
                            display: block;
                        }
                        
                        .user-joined {
                            font-size: 0.75rem;
                            color: #6c757d;
                            display: block;
                        }
                        
                        .role-badge {
                            font-size: 0.7rem;
                            padding: 0.25rem 0.5rem;
                            border-radius: 0.25rem;
                            display: inline-block;
                        }
                        
                        .role-admin {
                            background-color: #dc3545;
                            color: white;
                        }
                        
                        .role-leader {
                            background-color: #0d6efd;
                            color: white;
                        }
                        
                        .role-member {
                            background-color: #198754;
                            color: white;
                        }
                        
                        .status-pending {
                            display: flex;
                            align-items: center;
                            gap: 0.25rem;
                        }
                        
                        .status-actions {
                            display: flex;
                            gap: 0.25rem;
                        }
                        
                        .btn-xs {
                            padding: 0.2rem 0.4rem;
                            font-size: 0.7rem;
                            line-height: 1;
                            border-radius: 0.2rem;
                        }
                        
                        .action-buttons {
                            display: flex;
                            gap: 0.25rem;
                        }
                        
                        .badge-sm {
                            font-size: 0.7rem;
                            padding: 0.25rem 0.4rem;
                        }
                        
                        /* Ensure single line layout */
                        .compact-table tbody tr {
                            line-height: 1.2;
                        }
                        
                        .compact-table td {
                            height: 45px;
                        }
                        </style>
                    </div>
                </div>
            </div>

            <!-- Manage Leaders Section (Initially Hidden) -->
            <div id="manageLeadersSection" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-person-badge-fill me-2"></i>Manage Leaders
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Leadership Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $allUsers->where('role', 'leader')->count() }}</h4>
                                                <small>Total Leaders</small>
                                            </div>
                                            <i class="bi bi-shield fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $allUsers->where('role', 'leader')->where('membership_status', 'Active')->count() }}</h4>
                                                <small>Active Leaders</small>
                                            </div>
                                            <i class="bi bi-check-circle fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-secondary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="mb-0">{{ $allUsers->where('role', 'leader')->where('membership_status', 'Pending')->count() }}</h4>
                                                <small>Pending Leaders</small>
                                            </div>
                                            <i class="bi bi-clock fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Leaders Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-sm" id="manageLeadersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $leaders = $allUsers->where('role', 'leader');
                                    @endphp
                                    
                                    @foreach($leaders as $leader)
                                    <tr>
                                        <td>{{ $leader->id }}</td>
                                        <td>
                                            <small>{{ $leader->name }}</small>
                                        </td>
                                        <td><small>{{ $leader->email }}</small></td>
                                        <td><small>{{ $leader->phone_number ?: 'Not set' }}</small></td>
                                        <td><small>{{ $leader->gender ?: 'Not set' }}</small></td>
                                        <td>
                                            <span class="badge bg-{{ ($leader->membership_status ?? 'Active') == 'Active' ? 'success' : 'warning' }} badge-sm">
                                                {{ $leader->membership_status ?? 'Active' }}
                                            </span>
                                        </td>
                                        <td><small>{{ \Carbon\Carbon::parse($leader->created_at)->format('M d, Y') }}</small></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary btn-sm" onclick="viewLeaderDetails({{ $leader->id }})" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-warning btn-sm" onclick="editLeaderDetails({{ $leader->id }})" title="Edit Leader">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm" onclick="demoteLeader({{ $leader->id }}, '{{ $leader->name }}')" title="Demote to Member">
                                                    <i class="bi bi-arrow-down"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteLeader({{ $leader->id }}, '{{ $leader->name }}')" title="Delete Leader">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Section (Initially Hidden) -->
            <div id="reportsSection" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-file-earmark-text me-2"></i>Reports
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="bi bi-file-earmark-text display-1 text-primary mb-3"></i>
                                        <h5>General Reports</h5>
                                        <p class="text-muted">Generate system-wide reports and statistics</p>
                                        <button class="btn btn-primary w-100" onclick="showGeneralReports()">
                                            <i class="bi bi-bar-chart me-1"></i>General Reports
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="bi bi-people display-1 text-info mb-3"></i>
                                        <h5>Member Reports</h5>
                                        <p class="text-muted">Generate comprehensive member reports including registration and payment history</p>
                                        <button class="btn btn-info w-100" onclick="showMemberReports()">
                                            <i class="bi bi-person-badge me-1"></i>Member Reports
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <div id="reportsContent" style="display: none;">
                                <!-- Dynamic reports content will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Accounts Section (Initially Hidden) -->
            <div id="paymentAccountsSection" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-credit-card-fill me-2"></i>Payment Accounts
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="paymentAccountsList">
                            <!-- Payment accounts will be loaded here dynamically -->
                            <div class="text-center py-5">
                                <i class="bi bi-hourglass-split display-1 text-success mb-3"></i>
                                <h5>Loading Payment Accounts...</h5>
                                <p class="text-muted">Please wait while we fetch payment account data.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Announcements Section (Initially Hidden) -->
            <div id="announcementsSection" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-megaphone-fill me-2"></i>Announcements
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Create Announcement -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card bg-light border-primary">
                                    <div class="card-header bg-gradient-primary text-white py-2">
                                        <h5 class="mb-0 fs-6">
                                            <i class="bi bi-plus-circle me-2"></i>Create New Announcement
                                        </h5>
                                    </div>
                                    <div class="card-body py-3">
                                        <form id="createAnnouncementForm">
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small">Title</label>
                                                    <input type="text" class="form-control form-control-sm" id="announcementTitle" name="title" required placeholder="Enter title...">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Priority</label>
                                                    <select class="form-select form-select-sm" id="announcementPriority" name="priority" required>
                                                        <option value="normal">Normal</option>
                                                        <option value="important">Important</option>
                                                        <option value="urgent">Urgent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-2 mt-2">
                                                <div class="col-md-12">
                                                    <label class="form-label small">Message</label>
                                                    <textarea class="form-control form-control-sm" id="announcementMessage" name="message" rows="3" required placeholder="Enter your message..."></textarea>
                                                </div>
                                            </div>
                                            <div class="row g-2 mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small">Audience</label>
                                                    <select class="form-select form-select-sm" id="announcementAudience" name="audience" required>
                                                        <option value="all">All Users</option>
                                                        <option value="members">Members Only</option>
                                                        <option value="leaders">Leaders Only</option>
                                                        <option value="admins">Admins Only</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small">Expiry Date</label>
                                                    <input type="date" class="form-control form-control-sm" id="announcementExpiry" name="expiry_date">
                                                </div>
                                            </div>
                                            <div class="row g-2 mt-2">
                                                <div class="col-md-12">
                                                    <label class="form-label small">Image (Optional)</label>
                                                    <div class="announcement-image-upload">
                                                        <div class="image-upload-area" id="announcementImageUploadArea" style="min-height: 70px;">
                                                            <input type="file" id="announcementImage" name="announcement_image" accept="image/*" style="display: none;">
                                                            <div class="upload-placeholder" id="announcementUploadPlaceholder">
                                                                <i class="bi bi-cloud-upload fs-4 text-muted mb-1"></i>
                                                                <h6 class="small mb-0">Click to upload image</h6>
                                                                <p class="text-muted mb-0 small">PNG, JPG, GIF up to 2MB</p>
                                                            </div>
                                                            <div class="image-preview" id="announcementImagePreview" style="display: none;">
                                                                <img src="" alt="Announcement Image" class="preview-image">
                                                                <div class="image-overlay">
                                                                    <button type="button" class="btn btn-sm btn-danger" onclick="clearAnnouncementImage()">
                                                                        <i class="bi bi-trash"></i> Remove
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2 mt-3">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-send me-1"></i>Publish
                                                </button>
                                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="clearAnnouncementForm()">
                                                    <i class="bi bi-x-circle me-1"></i>Clear
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- View Announcements Button -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center py-5">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-megaphone fs-2 text-primary"></i>
                                        </div>
                                        <h4 class="text-primary mb-3">Announcements Management</h4>
                                        <p class="text-muted mb-4">Create, view, and manage all announcements from here.</p>
                                        <div class="d-flex justify-content-center gap-3">
                                            <button type="button" class="btn btn-primary btn-lg rounded-pill px-4" onclick="viewRecentAnnouncements()">
                                                <i class="bi bi-clock-history me-2"></i>View Published Announcements
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Announcement Modal (Initially Hidden) -->
            <div id="editAnnouncementModal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-pencil me-2"></i>Edit Announcement
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editAnnouncementForm">
                                <input type="hidden" id="editAnnouncementId" name="announcement_id">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Announcement Title</label>
                                        <input type="text" class="form-control" id="editAnnouncementTitle" name="title" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Priority</label>
                                        <select class="form-select" id="editAnnouncementPriority" name="priority" required>
                                            <option value="normal">Normal</option>
                                            <option value="important">Important</option>
                                            <option value="urgent">Urgent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Announcement Message</label>
                                        <textarea class="form-control" id="editAnnouncementMessage" name="message" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Target Audience</label>
                                        <select class="form-select" id="editAnnouncementAudience" name="audience" required>
                                            <option value="all">All Users</option>
                                            <option value="members">Members Only</option>
                                            <option value="leaders">Leaders Only</option>
                                            <option value="admins">Admins Only</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expiry Date (Optional)</label>
                                        <input type="date" class="form-control" id="editAnnouncementExpiry" name="expiry_date">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Update Image (Optional)</label>
                                        <div class="announcement-image-upload">
                                            <div class="image-upload-area" id="editAnnouncementImageUploadArea">
                                                <input type="file" id="editAnnouncementImage" name="announcement_image" accept="image/*" style="display: none;">
                                                <div class="upload-placeholder" id="editAnnouncementUploadPlaceholder">
                                                    <i class="bi bi-cloud-upload fs-3 text-muted mb-2"></i>
                                                    <h6 class="small">Click to upload new image</h6>
                                                    <p class="text-muted mb-0 small">or drag and drop</p>
                                                    <p class="text-muted mb-0 small">PNG, JPG, GIF up to 2MB</p>
                                                </div>
                                                <div class="image-preview" id="editAnnouncementImagePreview" style="display: none;">
                                                    <img src="" alt="Announcement Image" class="preview-image">
                                                    <div class="image-overlay">
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="clearEditAnnouncementImage()">
                                                            <i class="bi bi-trash"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="current-image-preview" id="editCurrentImagePreview" style="display: none;">
                                            <label class="form-label">Current Image:</label>
                                            <img src="" alt="Current Image" class="current-image-display">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="removeCurrentImage" name="remove_current_image">
                                                <label class="form-check-label" for="removeCurrentImage">
                                                    Remove current image
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-warning" onclick="updateAnnouncement()">
                                <i class="bi bi-save me-2"></i>Update Announcement
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Add CSS for announcement image upload -->
            <style>
                .announcement-image-upload {
                    margin-top: 10px;
                }
                
                .image-upload-area {
                    border: 2px dashed #e9ecef;
                    border-radius: 8px;
                    padding: 20px;
                    text-align: center;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    position: relative;
                    min-height: 120px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .image-upload-area:hover {
                    border-color: #ffc107;
                    background-color: #fff8e1;
                }
                
                .image-upload-area.dragover {
                    border-color: #ffc107;
                    background-color: #fff8e1;
                    transform: scale(1.02);
                }
                
                .upload-placeholder {
                    pointer-events: none;
                }
                
                .image-preview {
                    position: relative;
                    width: 100%;
                    max-height: 200px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .preview-image {
                    max-width: 100%;
                    max-height: 200px;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                
                .image-overlay {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
                
                .image-preview:hover .image-overlay {
                    opacity: 1;
                }
                
                .announcement-card-with-image {
                    position: relative;
                    text-align: center;
                }
                
                .announcement-image-display {
                    max-width: 100%;
                    max-height: 250px;
                    width: auto;
                    height: auto;
                    border-radius: 12px;
                    margin-bottom: 15px;
                    display: inline-block;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
                    object-fit: contain;
                    transition: all 0.3s ease;
                    border: 3px solid rgba(255, 255, 255, 0.8);
                    background: rgba(255, 255, 255, 0.1);
                }
                
                .announcement-image-container {
                    text-align: center;
                    margin-bottom: 15px;
                    position: relative;
                    background: rgba(255, 255, 255, 0.05);
                    border-radius: 15px;
                    padding: 10px;
                    border: 1px solid rgba(255, 255, 255, 0.1);
                }
                
                .current-image-display {
                    max-width: 200px;
                    max-height: 150px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }
            </style>
            
            <!-- Make Payments Section (Initially Hidden) -->
            <div id="makePaymentsSection" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-cash-coin me-2"></i>Make Payments
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs mb-4" id="paymentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="personal-payment-tab" data-bs-toggle="tab" data-bs-target="#personal-payment" type="button" role="tab" aria-controls="personal-payment" aria-selected="true">
                                    <i class="bi bi-person-check-fill me-2"></i>My Personal Payment
                                </button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="member-payments-tab" data-bs-toggle="tab" data-bs-target="#member-payments" type="button" role="tab" aria-controls="member-payments" aria-selected="false">
                                    <i class="bi bi-people-fill me-2"></i>Member Payments
                                </button>
                            </li> -->
                        </ul>
                        

                        <!-- Tab Content -->
                        <div class="tab-content" id="paymentTabContent">
                            <!-- Personal Payment Tab -->
                            <div class="tab-pane fade show active" id="personal-payment" role="tabpanel" aria-labelledby="personal-payment-tab">
                                <form id="adminPaymentForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <!-- Payment Type -->
                                        <div class="col-md-6">
                                            <label for="adminPaymentType" class="form-label">
                                                <i class="bi bi-list-task me-1"></i>Payment Type <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="adminPaymentType" name="payment_type" required onchange="handleAdminPaymentTypeChange()">
                                                <option value="">Select Payment Type...</option>
                                                <option value="membership">Membership Fee - TZS 2,000</option>
                                                <option value="certificate">Certificate Fee - TZS 4,000</option>
                                                <option value="zaka">Zaka - TZS 2,000</option>
                                                <!-- <option value="donation">Donation</option>
                                                <option value="event">Event Fee</option>
                                                <option value="other">Other</option> -->
                                            </select>
                                        </div>

                                        <!-- Payment Year -->
                                        <div class="col-md-6">
                                            <label for="adminPaymentYear" class="form-label">
                                                <i class="bi bi-calendar me-1"></i>Payment Year <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="adminPaymentYear" name="payment_year" required onchange="handleAdminYearChange()">
                                                <option value="">Select Year...</option>
                                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                                                <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                                                <option value="custom_year">Custom Year (Enter New Year)</option>
                                            </select>
                                        </div>

                                        <!-- Custom Year Input -->
                                        <div class="col-md-6" id="adminCustomYearDiv" style="display: none;">
                                            <label for="adminCustomYear" class="form-label">
                                                <i class="bi bi-calendar-plus me-1"></i>Enter Custom Year
                                            </label>
                                            <input type="number" class="form-control" id="adminCustomYear" name="custom_year" min="2020" max="2050" placeholder="e.g., 2030">
                                        </div>

                                        <!-- Amount -->
                                        <div class="col-md-6">
                                            <label for="adminPaymentAmount" class="form-label">
                                                <i class="bi bi-cash me-1"></i>Amount (TZS) <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">TZS</span>
                                                <input type="number" class="form-control" id="adminPaymentAmount" name="amount" min="0" step="0.01" required>
                                            </div>
                                        </div>

                                        <!-- Payment Method -->
                                        <div class="col-md-6">
                                            <label for="adminPaymentMethod" class="form-label">
                                                <i class="bi bi-credit-card me-1"></i>Payment Method <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="adminPaymentMethod" name="payment_method" required onchange="showAdminPaymentDetails()">
                                                <option value="">Loading payment methods...</option>
                                            </select>
                                        </div>

                                        <!-- Sender Name -->
                                        <div class="col-md-6">
                                            <label for="adminSenderName" class="form-label">
                                                <i class="bi bi-person me-1"></i>Sender Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="adminSenderName" name="sender_name" placeholder="Enter your full name" required>
                                        </div>

                                        <!-- Installment Type -->
                                        <div class="col-md-6" id="adminInstallmentOptions" style="display: none;">
                                            <label for="adminInstallmentType" class="form-label">
                                                <i class="bi bi-calendar-split me-1"></i>Payment Option
                                            </label>
                                            <select class="form-select" id="adminInstallmentType" name="installment_type" onchange="handleAdminInstallmentChange()">
                                                <option value="">Select payment option...</option>
                                                <option value="full">Full Payment</option>
                                            </select>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12">
                                            <label for="adminPaymentDescription" class="form-label">
                                                <i class="bi bi-text-paragraph me-1"></i>Description <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="adminPaymentDescription" name="description" rows="3" required placeholder="Enter payment description..."></textarea>
                                        </div>

                                        <!-- Payment Details Section -->
                                        <div class="col-12" id="adminPaymentDetailsSection" style="display: none;">
                                            <div class="alert alert-info">
                                                <h6 class="alert-heading">
                                                    <i class="bi bi-info-circle me-2"></i>Payment Instructions
                                                </h6>
                                                <div id="adminPaymentInstructions"></div>
                                            </div>
                                        </div>

                                        <!-- Installment Info -->
                                        <div class="col-12" id="adminInstallmentInfo" style="display: none;">
                                            <div class="alert alert-info d-flex align-items-center">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <div id="adminInstallmentInfoText"></div>
                                            </div>
                                        </div>

                                        <!-- Attachment -->
                                        <div class="col-12">
                                            <label for="adminPaymentAttachment" class="form-label">
                                                <i class="bi bi-paperclip me-1"></i>Payment Proof <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" class="form-control" id="adminPaymentAttachment" name="attachment" accept="image/*,.pdf" onchange="previewAdminAttachment(this)" required>
                                            <div class="form-text">Upload payment receipt or proof (PNG, JPG, PDF - Max 2MB)</div>
                                            <div id="adminAttachmentPreview" class="mt-2" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0">
                                                            <i class="bi bi-eye me-2"></i>Preview
                                                        </h6>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAdminAttachment()">
                                                            <i class="bi bi-trash"></i> Remove
                                                        </button>
                                                    </div>
                                                    <div class="card-body text-center p-3">
                                                        <div id="adminAttachmentPreviewContent"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Buttons -->
                                        <div class="col-12 mt-4">
                                            <div class="d-flex justify-content-between gap-2">
                                                <button type="button" class="btn btn-outline-secondary" onclick="resetAdminPaymentForm()">
                                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                                                </button>
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="bi bi-cash-coin me-2"></i>Submit My Payment
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Member Payments Tab -->
                            <div class="tab-pane fade" id="member-payments" role="tabpanel" aria-labelledby="member-payments-tab">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Member payment management functionality will be available here. You can view, approve, and manage member payments.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="memberPaymentsSection" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-cash-stack me-2"></i>Member Payments
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Payment Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Payments</h5>
                                        <h3 id="adminTotalPayments">0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Pending</h5>
                                        <h3 id="adminPendingAmount">TZS 0</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Approved</h5>
                                        <h3 id="adminApprovedAmount">TZS 0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <select class="form-select" id="adminYearFilter" onchange="filterAdminPayments()">
                                    <option value="">All Years</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="adminTypeFilter" onchange="filterAdminPayments()">
                                    <option value="">All Types</option>
                                    <option value="membership">Membership Fee</option>
                                    <option value="certificate">Certificate Fee</option>
                                    <option value="zaka">Zaka</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="adminStatusFilter" onchange="filterAdminPayments()">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>

                        <!-- Payment List -->
                        <div id="adminPaymentList">
                            <div class="text-center py-5">
                                <i class="bi bi-hourglass-split" style="font-size: 3rem;"></i>
                                <p class="mt-3">Loading payments...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Profile Section (Initially Hidden) -->
            <div id="myProfileSection" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>My Profile
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="profileContent">
                            @php
                                $currentUser = auth()->user();
                                if ($currentUser) {
                                    echo '<div class="row">
                                        <!-- Profile Picture Section -->
                                        <div class="col-md-4 text-center">
                                            <div class="mb-3">
                                                <div class="profile-upload-area">
                                                    ' . ($currentUser->profile_picture ? 
                                                        '<img src="/uploads/profiles/' . $currentUser->profile_picture . '" class="img-fluid rounded-circle" style="max-width: 150px; height: 150px; object-fit: cover;" alt="Profile Picture">' :
                                                        '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; margin: 0 auto;">
                                                            <i class="bi bi-person fs-1 text-muted"></i>
                                                        </div>'
                                                    ) . '
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-warning btn-sm" onclick="editMyProfile(' . $currentUser->id . ')" id="editProfileBtn">
                                                    <i class="bi bi-pencil me-1"></i>Edit Profile
                                                </button>
                                                <button type="button" class="btn btn-info btn-sm ms-2" onclick="changePassword(' . $currentUser->id . ')">
                                                    <i class="bi bi-key me-1"></i>Change Password
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm ms-2" onclick="changeProfilePicture(' . $currentUser->id . ')">
                                                    <i class="bi bi-camera me-1"></i>Change Photo
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Profile Information Section -->
                                        <div class="col-md-8">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title text-primary mb-4">
                                                        <i class="bi bi-person-badge me-2"></i>Personal Information
                                                    </h5>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-person me-2"></i>Full Name:</strong>
                                                            <span class="ms-2">' . htmlspecialchars($currentUser->name) . '</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-envelope me-2"></i>Email:</strong>
                                                            <span class="ms-2">' . htmlspecialchars($currentUser->email) . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-telephone me-2"></i>Phone:</strong>
                                                            <span class="ms-2">' . htmlspecialchars($currentUser->phone_number ?? 'Not provided') . '</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-geo-alt me-2"></i>Address:</strong>
                                                            <span class="ms-2">' . htmlspecialchars($currentUser->address ?? 'Not provided') . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-calendar me-2"></i>Date of Birth:</strong>
                                                            <span class="ms-2">' . ($currentUser->date_of_birth ? date('M d, Y', strtotime($currentUser->date_of_birth)) : 'Not provided') . '</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-gender me-2"></i>Gender:</strong>
                                                            <span class="ms-2">' . htmlspecialchars(ucfirst($currentUser->gender ?? 'Not specified')) . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-shield-check me-2"></i>Role:</strong>
                                                            <span class="ms-2">
                                                                <span class="badge bg-primary">' . htmlspecialchars(ucfirst($currentUser->role)) . '</span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong><i class="bi bi-card me-2"></i>Member ID:</strong>
                                                            <span class="ms-2">TMCS-' . str_pad($currentUser->id, 4, '0', STR_PAD_LEFT) . '</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.role-badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-admin {
    background: linear-gradient(135deg, #dc3545 0%, #c8232a 100%);
    color: white;
    border: 1px solid #dc3545;
}

/* Admin Payment Actions Button Fix */
.admin-payment-actions {
    display: flex;
    flex-direction: column;
    gap: 2px;
    justify-content: center;
    align-items: center;
    min-width: 60px;
}

.admin-payment-actions .btn {
    padding: 3px 6px !important;
    font-size: 10px !important;
    line-height: 1 !important;
    min-width: 25px;
    height: 25px;
    border-radius: 3px;
}

.admin-payment-actions .btn i {
    font-size: 10px !important;
    margin: 0 !important;
}

/* Ensure table rows don't overflow */
.admin-payment-row {
    min-height: 60px;
    align-items: center !important;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .admin-payment-actions .btn {
        padding: 2px 4px !important;
        font-size: 9px !important;
        min-width: 22px;
        height: 22px;
    }
    
    .admin-payment-actions .btn i {
        font-size: 9px !important;
    }
}

.role-leader {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    border: 1px solid #3498db;
}

.role-member {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: 1px solid #28a745;
}

.section-title {
    color: #2d3436;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.3rem;
    border-bottom: 2px solid #6c5ce7;
    font-size: 1.1rem;
}

.profile-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    background: #f8f9fa;
}

.profile-upload-area:hover {
    border-color: #6c5ce7;
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

.content-section {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.list-group-item {
    border: none;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.list-group-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.btn-outline-danger {
    border-radius: 8px;
    padding: 10px 20px;
}

h5.text-primary {
    color: #667eea !important;
    font-weight: 600;
    border-bottom: 2px solid #667eea;
    padding-bottom: 5px;
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

.content-section {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    .table-sm td {
        padding: 0.25rem;
    }
    
    .badge-sm {
        font-size: 0.6rem;
        padding: 0.2rem 0.4rem;
    }
}
</style>

<script>
// Profile Picture Upload Functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('profile_picture');
    const chooseFileBtn = document.getElementById('chooseFileBtn');
    const previewContainer = document.getElementById('previewContainer');

    if (dropZone && fileInput && chooseFileBtn) {
        // Click to choose file
        chooseFileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });

        // Click drop zone to choose file
        dropZone.addEventListener('click', function() {
            fileInput.click();
        });

        // Drag and drop functionality
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.style.borderColor = '#6c5ce7';
            dropZone.style.background = '#f0fff4';
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
            dropZone.style.background = '#f8f9fa';
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.style.borderColor = '#dee2e6';
            dropZone.style.background = '#f8f9fa';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        function handleFileSelect(file) {
            // Check if file is an image
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file (JPG, PNG, GIF)');
                return;
            }

            // Check file size (2MB limit)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                return;
            }

            // Preview the image
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `
                    <img src="${e.target.result}" class="preview-image" alt="Profile Preview">
                    <h6 class="small text-success mb-2">Image Selected</h6>
                    <p class="text-muted mb-0 small">${file.name}</p>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="clearImage()">
                        <i class="bi bi-trash me-1"></i>Remove
                    </button>
                `;
            };
            reader.readAsDataURL(file);
        }

        // Clear image function
        window.clearImage = function() {
            fileInput.value = '';
            previewContainer.innerHTML = `
                <i class="bi bi-cloud-upload fs-3 text-muted mb-2"></i>
                <h6 class="small">Drag & Drop photo</h6>
                <p class="text-muted mb-2 small">or</p>
                <button type="button" class="btn btn-sm btn-outline-primary" id="chooseFileBtn">
                    <i class="bi bi-folder2-open me-1"></i>Choose File
                </button>
            `;
            
            // Re-attach event listener to new button
            const newBtn = document.getElementById('chooseFileBtn');
            if (newBtn) {
                newBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    fileInput.click();
                });
            }
        };
    }
});

function showAddMemberForm() {
    hideAllSections();
    document.getElementById('addMemberForm').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(document.querySelector('.list-group-item'));
}

function showManageUsers() {
    hideAllSections();
    document.getElementById('manageUsersSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(1);
}

function showManageLeaders() {
    hideAllSections();
    document.getElementById('manageLeadersSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(2);
}


function showPaymentAccounts() {
    console.log('showPaymentAccounts function called');
    hideAllSections();
    document.getElementById('paymentAccountsSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(event.target.closest('.list-group-item'));
    loadAccounts();
}

function loadAccounts() {
    console.log('Loading accounts...');
    fetch('/admin/accounts')
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data);
            if (data.success) {
                console.log('Displaying accounts:', data.all_accounts);
                displayAccounts(data.all_accounts);
            } else {
                console.error('Failed to load accounts:', data.message);
                // Show error message
                const container = document.getElementById('paymentAccountsList');
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bi bi-exclamation-triangle display-1 text-danger mb-3"></i>
                        <h5>Error Loading Accounts</h5>
                        <p class="text-muted">${data.message || 'Please try again later.'}</p>
                        <button class="btn btn-primary" onclick="loadAccounts()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Retry
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading accounts:', error);
            // Show error message
            const container = document.getElementById('paymentAccountsList');
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-exclamation-triangle display-1 text-danger mb-3"></i>
                    <h5>Connection Error</h5>
                    <p class="text-muted">Failed to connect to server. Please check your connection.</p>
                    <button class="btn btn-primary" onclick="loadAccounts()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Retry
                    </button>
                </div>
            `;
        });
}

function displayAccounts(accounts) {
    const container = document.getElementById('paymentAccountsList');
    
    console.log('displayAccounts called with:', accounts);
    
    if (!accounts || accounts.length === 0) {
        console.log('No accounts found, showing empty state');
        container.innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                <h5>No Accounts Found</h5>
                <p class="text-muted">No payment accounts have been added yet.</p>
                <button class="btn btn-primary" onclick="showAddAccountForm()">
                    <i class="bi bi-plus-circle me-2"></i>Add First Account
                </button>
            </div>
        `;
        return;
    }
    
    let html = `
        <div class="row mb-4">
            <div class="col-md-6">
                <button class="btn btn-primary" onclick="showAddAccountForm()">
                    <i class="bi bi-plus-circle me-2"></i>Add New Account
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Network/Bank</th>
                        <th>Number</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    accounts.forEach(account => {
        html += `
            <tr>
                <td>${account.id}</td>
                <td>
                    <span class="badge ${account.account_type === 'mobile' ? 'bg-primary' : 'bg-info'}">
                        ${account.account_type === 'mobile' ? 'Mobile Money' : 'Bank Account'}
                    </span>
                </td>
                <td>${account.account_name}</td>
                <td>${account.network_bank || '-'}</td>
                <td><strong>${account.account_number}</strong></td>
                <td>
                    <span class="badge ${account.status === 'active' ? 'bg-success' : 'bg-danger'}">
                        ${account.status}
                    </span>
                </td>
                <td>${account.formatted_created_at || 'N/A'}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="editAccount(${account.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteAccount(${account.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
        
        <style>
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table {
                margin-bottom: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                font-size: 0.85rem;
            }
            
            .table th {
                font-weight: 600;
                color: #495057;
                border-bottom: 2px solid #dee2e6;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .table td {
                vertical-align: middle;
                border-bottom: 1px solid #f8f9fa;
                font-size: 0.85rem;
            }
            
            /* Modal improvements */
            .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }
            
            .modal-dialog-centered {
                display: flex;
                align-items: center;
                min-height: calc(100% - 1rem);
            }
            
            .modal-content {
                max-height: 90vh;
                display: flex;
                flex-direction: column;
            }
            
            .modal-body {
                overflow-y: auto;
                flex: 1;
            }
            
            .modal-xl {
                max-width: 95vw;
            }
            
            @media (max-width: 768px) {
                .modal-xl {
                    max-width: 100vw;
                    margin: 0;
                }
                
                .modal-dialog-centered {
                    min-height: 100vh;
                    align-items: flex-start;
                }
                
                .modal-content {
                    max-height: 100vh;
                    border-radius: 0;
                }
                
                .modal-body {
                    padding: 1rem;
                }
            }
            
            /* Ensure proper scrolling in modal body */
            .modal-body::-webkit-scrollbar {
                width: 6px;
            }
            
            .modal-body::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }
            
            .modal-body::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 3px;
            }
            
            .modal-body::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }
            
            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
                border-bottom: 2px solid #dee2e6;
                white-space: nowrap;
                padding: 12px 8px;
            }
            
            .table td {
                padding: 10px 8px;
                vertical-align: middle;
                border-bottom: 1px solid #e9ecef;
            }
            
            .table tr:hover {
                background-color: #f8f9fa;
            }
            
            .badge {
                padding: 6px 12px;
                font-size: 0.75rem;
                font-weight: 500;
                border-radius: 20px;
            }
            
            .btn-group {
                display: flex;
                gap: 4px;
            }
            
            .btn-sm {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            @media (max-width: 768px) {
                .table {
                    font-size: 0.8rem;
                }
                
                .table th, .table td {
                    padding: 8px 6px;
                }
                
                .btn-sm {
                    padding: 4px 8px;
                    font-size: 0.75rem;
                }
            }
        </style>
    `;
    
    console.log('Setting container HTML');
    container.innerHTML = html;
}

function showAddAccountForm() {
    const formHtml = `
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Account</h5>
            </div>
            <div class="card-body">
                <form id="addAccountForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Type</label>
                            <select class="form-select" id="accountType" name="account_type" required onchange="handleAccountTypeChange()">
                                <option value="">Select Account Type</option>
                                <option value="mobile">Mobile</option>
                                <option value="bank">Bank</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="accountStatus" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Name</label>
                            <input type="text" class="form-control" id="accountName" name="account_name" required>
                        </div>
                        <div class="col-md-6 mb-3" id="networkBankField" style="display: none;">
                            <label class="form-label" id="networkBankLabel">Network/Bank</label>
                            <select class="form-select" id="networkBank" name="network_bank">
                                <option value="">Select...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" id="accountNumber" name="account_number" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Save Account
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="loadAccounts()">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <style>
            .form-label {
                font-weight: 600;
                color: #495057;
                margin-bottom: 8px;
            }
            
            .form-control, .form-select {
                border: 2px solid #e9ecef;
                border-radius: 8px;
                padding: 12px 16px;
                font-size: 0.95rem;
                transition: all 0.3s ease;
                width: 100%;
            }
            
            .form-control:focus, .form-select:focus {
                border-color: #28a745;
                box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            }
            
            .row {
                margin-bottom: 20px;
            }
            
            .mb-3 {
                margin-bottom: 24px;
            }
            
            .d-flex {
                display: flex;
                align-items: center;
            }
            
            .gap-2 {
                gap: 12px;
            }
            
            .btn {
                padding: 12px 24px;
                border-radius: 8px;
                font-weight: 500;
                border: none;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .btn-success {
                background: linear-gradient(135deg, #28a745, #20c997);
                color: white;
            }
            
            .btn-success:hover {
                background: linear-gradient(135deg, #218838, #1e7e34);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
            }
            
            .btn-secondary {
                background: #6c757d;
                color: white;
            }
            
            .btn-secondary:hover {
                background: #5c636a;
                transform: translateY(-2px);
            }
            
            @media (max-width: 768px) {
                .col-md-6 {
                    margin-bottom: 16px;
                }
                
                .form-control, .form-select {
                    padding: 10px 12px;
                    font-size: 0.9rem;
                }
                
                .btn {
                    padding: 10px 20px;
                    font-size: 0.9rem;
                }
            }
        </style>
    `;
    
    document.getElementById('paymentAccountsList').innerHTML = formHtml;
    
    // Add form submit handler
    document.getElementById('addAccountForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Always include network_bank field value
        const networkBankElement = document.getElementById('networkBank');
        let networkBankValue = '';
        
        if (networkBankElement) {
            networkBankValue = networkBankElement.value || '';
            console.log('Found networkBank element, value:', networkBankValue);
        } else {
            console.log('networkBank element not found!');
        }
        
        formData.set('network_bank', networkBankValue);
        
        // Debug: Log all form data being submitted
        console.log('=== FORM SUBMISSION DEBUG ===');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': "' + value + '"');
        }
        console.log('networkBank element exists:', !!networkBankElement);
        console.log('networkBank element value:', networkBankValue);
        console.log('============================');
        
        fetch('/admin/accounts', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Account added successfully!');
                loadAccounts();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding account. Please try again.');
        });
    });
}

function handleAccountTypeChange() {
    const accountType = document.getElementById('accountType').value;
    const networkBankField = document.getElementById('networkBankField');
    const networkBankLabel = document.getElementById('networkBankLabel');
    const networkBankSelect = document.getElementById('networkBank');
    
    if (accountType === 'mobile') {
        // Show mobile networks
        networkBankField.style.display = 'block';
        networkBankLabel.textContent = 'Mobile Network';
        networkBankSelect.innerHTML = `
            <option value="">Select Mobile Network...</option>
             <option value="M-Pesa">M-Pesa</option>
            <option value="Mixx By Yas">Mixx By Yas</option>
            <option value="Airtel Money">Airtel Money</option>
            <option value="Halopesa">Halopesa</option>
            
            <option value="Zantel">Zantel</option>
            <option value="Banglalink">Banglalink</option>
            <option value="TTCL">TTCL</option>
            <option value="Smile">Smile</option>
        
        `;
        networkBankSelect.required = true;
    } else if (accountType === 'bank') {
        // Show banks
        networkBankField.style.display = 'block';
        networkBankLabel.textContent = 'Bank Name';
        networkBankSelect.innerHTML = `
            <option value="">Select Bank...</option>
            <option value="NMB">NMB Bank</option>
            <option value="CRDB">CRDB Bank</option>
            <option value="NBC">National Bank of Commerce (NBC)</option>
            <option value="KCB">KCB Bank Tanzania</option>
            <option value="Stanbic">Stanbic Bank</option>
            <option value="Absa">Absa Bank Tanzania</option>
            <option value="Diamond">Diamond Trust Bank</option>
            <option value="Equity">Equity Bank Tanzania</option>
            <option value="Azania">Azania Bank</option>
            <option value="Bank of Africa">Bank of Africa</option>
            <option value="Commercial Bank">Commercial Bank of Africa</option>
            <option value="People's Bank">People's Bank of Tanzania</option>
            <option value="TPB">TPB Bank</option>
            <option value="Exim">Exim Bank</option>
            <option value="Mkombozi">Mkombozi Commercial Bank</option>
        `;
        networkBankSelect.required = true;
    } else {
        // Hide the field
        networkBankField.style.display = 'none';
        networkBankSelect.required = false;
        networkBankSelect.innerHTML = '<option value="">Select...</option>';
    }
}

function handleEditAccountTypeChange() {
    const accountType = document.getElementById('editAccountType').value;
    const networkBankField = document.getElementById('editNetworkBankField');
    const networkBankLabel = document.getElementById('editNetworkBankLabel');
    const networkBankSelect = document.getElementById('editNetworkBank');
    
    // Store current value before changing options
    const currentValue = networkBankSelect.value;
    
    if (accountType === 'mobile') {
        // Show mobile networks
        networkBankField.style.display = 'block';
        networkBankLabel.textContent = 'Mobile Network';
        networkBankSelect.innerHTML = `
            <option value="">Select Mobile Network...</option>
            <option value="M-Pesa">M-Pesa</option>
            <option value="Mixx By Yas">Mixx By Yas</option>
            <option value="Airtel Money">Airtel Money</option>
            <option value="Halopesa">Halopesa</option>
            
            <option value="Zantel">Zantel</option>
            <option value="Banglalink">Banglalink</option>
            <option value="TTCL">TTCL</option>
            <option value="Smile">Smile</option>
        
        `;
        networkBankSelect.required = true;
    } else if (accountType === 'bank') {
        // Show banks
        networkBankField.style.display = 'block';
        networkBankLabel.textContent = 'Bank Name';
        networkBankSelect.innerHTML = `
            <option value="">Select Bank...</option>
            <option value="NMB">NMB Bank</option>
            <option value="CRDB">CRDB Bank</option>
            <option value="NBC">National Bank of Commerce (NBC)</option>
            <option value="KCB">KCB Bank Tanzania</option>
            <option value="Stanbic">Stanbic Bank</option>
            <option value="Absa">Absa Bank Tanzania</option>
            <option value="Diamond">Diamond Trust Bank</option>
            <option value="Equity">Equity Bank Tanzania</option>
            <option value="Azania">Azania Bank</option>
            <option value="Bank of Africa">Bank of Africa</option>
            <option value="Commercial Bank">Commercial Bank of Africa</option>
            <option value="People's Bank">People's Bank of Tanzania</option>
            <option value="TPB">TPB Bank</option>
            <option value="Exim">Exim Bank</option>
            <option value="Mkombozi">Mkombozi Commercial Bank</option>
        `;
        networkBankSelect.required = true;
    } else {
        // Hide the field
        networkBankField.style.display = 'none';
        networkBankSelect.required = false;
        networkBankSelect.innerHTML = '<option value="">Select...</option>';
    }
    
    // Restore the previous value if it exists in the new options
    if (currentValue) {
        networkBankSelect.value = currentValue;
    }
}

function editAccount(id) {
    // Fetch account data and show edit form
    fetch('/admin/accounts')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const account = data.all_accounts.find(acc => acc.id === id);
                
                if (account) {
                    showEditAccountForm(account);
                } else {
                    alert('Account not found!');
                }
            } else {
                alert('Failed to fetch account data!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching account. Please try again.');
        });
}

function showEditAccountForm(account) {
    const formHtml = `
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Account</h5>
            </div>
            <div class="card-body">
                <form id="editAccountForm">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" id="editAccountId" name="id" value="${account.id}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Type</label>
                            <select class="form-select" id="editAccountType" name="account_type" required onchange="handleEditAccountTypeChange()">
                                <option value="mobile" ${account.account_type === 'mobile' ? 'selected' : ''}>Mobile</option>
                                <option value="bank" ${account.account_type === 'bank' ? 'selected' : ''}>Bank</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editAccountStatus" name="status" required>
                                <option value="active" ${account.status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${account.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Name</label>
                            <input type="text" class="form-control" id="editAccountName" name="account_name" value="${account.account_name}" required>
                        </div>
                        <div class="col-md-6 mb-3" id="editNetworkBankField" style="display: none;">
                            <label class="form-label" id="editNetworkBankLabel">Network/Bank</label>
                            <select class="form-select" id="editNetworkBank" name="network_bank">
                                <option value="">Select...</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" id="editAccountNumber" name="account_number" value="${account.account_number}" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle me-2"></i>Update Account
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="loadAccounts()">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    document.getElementById('paymentAccountsList').innerHTML = formHtml;
    
    // Initialize the network/bank field based on the current account type
    setTimeout(() => {
        handleEditAccountTypeChange();
        
        // Set the current network/bank value if it exists
        if (account.network_bank) {
            // Wait a bit longer for the options to be populated
            setTimeout(() => {
                document.getElementById('editNetworkBank').value = account.network_bank;
            }, 50);
        }
    }, 100);
    
    // Add form submit handler
    document.getElementById('editAccountForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const accountId = document.getElementById('editAccountId').value;
        
        // Ensure network_bank field is always included
        if (!formData.has('network_bank')) {
            const networkBankValue = document.getElementById('editNetworkBank').value || '';
            formData.append('network_bank', networkBankValue);
        }
        
        fetch(`/admin/accounts/${accountId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert('Account updated successfully!');
                loadAccounts();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating account. Please try again.');
        });
    });
}

function deleteAccount(id) {
    if (confirm('Are you sure you want to delete this account?')) {
        fetch(`/admin/accounts/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Account deleted successfully!');
                loadAccounts();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting account. Please try again.');
        });
    }
}

function showMemberPayments() {
    hideAllSections();
    document.getElementById('memberPaymentsSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(event.target.closest('.list-group-item'));
    loadAdminPayments();
}

function showMyProfile() {
    console.log('showMyProfile function called');
    hideAllSections();
    document.getElementById('myProfileSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    // Update active menu item - handle both click and hash navigation
    if (event && event.target) {
        // Called from click event
        updateActiveMenu(event.target.closest('.list-group-item'));
    } else {
        // Called from hash navigation or programmatically
        const profileMenuItem = Array.from(document.querySelectorAll('.list-group-item')).find(item => 
            item.textContent.includes('My Profile')
        );
        if (profileMenuItem) {
            updateActiveMenu(profileMenuItem);
        }
    }
    
    loadMyProfile();
}

function loadAdminPayments() {
    console.log('Loading admin payments...');
    
    // Load all payments from backend
    fetch('/admin/payments/all', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Admin payments response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Admin payments data received:', data);
        if (data.success) {
            console.log('Raw payments from backend:', data.payments);
            console.log('Payment statuses:', data.payments.map(p => ({id: p.id, status: p.status, amount: p.amount})));
            
            const payments = data.payments.map(payment => ({
                id: payment.id,
                payment_type: payment.payment_type,
                amount: payment.amount,
                description: payment.description,
                payment_method: payment.payment_method,
                sender_name: payment.sender_name,
                installment_type: payment.installment_type,
                payment_year: payment.payment_year,
                status: payment.status,
                created_at: payment.created_at,
                attachment: payment.attachment,
                user_id: payment.user_id,
                user_name: payment.user ? payment.user.name : 'Unknown',
                user_email: payment.user ? payment.user.email : 'Unknown',
                user_phone: payment.user ? payment.user.phone_number : 'Not provided',
                user_role: payment.user ? payment.user.role : 'Unknown'
            }));
            
            console.log('Processed payments:', payments);
            console.log('Rejected payments:', payments.filter(p => p.status === 'rejected'));
            console.log('Pending payments:', payments.filter(p => p.status === 'pending'));
            console.log('Completed payments:', payments.filter(p => p.status === 'completed'));
            
            // Store payments globally for filtering
            window.adminAllPayments = payments;
            
            // Populate year filter
            populateAdminYearFilter(payments);
            
            // Display all payments initially
            displayAdminPayments(payments);
            updateAdminPaymentStatistics(payments);
        } else {
            console.error('Error loading admin payments:', data.message);
            displayAdminPayments([]);
            updateAdminPaymentStatistics([]);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        displayAdminPayments([]);
        updateAdminPaymentStatistics([]);
    });
}

function populateAdminYearFilter(payments) {
    const yearSelect = document.getElementById('adminYearFilter');
    const years = [...new Set(payments.map(p => parseInt(p.payment_year)))].sort((a, b) => b - a);
    
    console.log('Populating admin year filter with years:', years);
    
    // Clear existing options except first
    yearSelect.innerHTML = '<option value="">All Years</option>';
    
    // Add year options
    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    });
}

function filterAdminPayments() {
    const yearFilter = document.getElementById('adminYearFilter').value;
    const typeFilter = document.getElementById('adminTypeFilter').value;
    const statusFilter = document.getElementById('adminStatusFilter').value;
    
    console.log('filterAdminPayments called - Year:', yearFilter, 'Type:', typeFilter, 'Status:', statusFilter);
    
    let filteredPayments = window.adminAllPayments;
    
    // Filter by year
    if (yearFilter) {
        const targetYear = parseInt(yearFilter);
        filteredPayments = filteredPayments.filter(p => {
            const paymentYear = parseInt(p.payment_year);
            return paymentYear === targetYear;
        });
    }
    
    // Filter by type
    if (typeFilter) {
        filteredPayments = filteredPayments.filter(p => p.payment_type === typeFilter);
    }
    
    // Filter by status
    if (statusFilter) {
        filteredPayments = filteredPayments.filter(p => p.status === statusFilter);
    }
    
    console.log('Final filtered admin payments:', filteredPayments);
    
    // Display filtered results
    displayAdminPayments(filteredPayments);
    
    // Update statistics based on filtered results
    updateAdminPaymentStatistics(filteredPayments);
}

function updateAdminPaymentStatistics(payments) {
    const totalPayments = payments.length;
    
    // Calculate total amount for pending payments only
    const pendingPayments = payments.filter(p => p.status === 'pending');
    const totalPendingAmount = pendingPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
    
    // Calculate total amount for approved payments only
    const approvedPayments = payments.filter(p => p.status === 'completed');
    const totalApprovedAmount = approvedPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
    
    // Update UI
    document.getElementById('adminTotalPayments').textContent = totalPayments;
    document.getElementById('adminPendingAmount').textContent = `TZS ${totalPendingAmount.toLocaleString()}`;
    document.getElementById('adminApprovedAmount').textContent = `TZS ${totalApprovedAmount.toLocaleString()}`;
}

function displayAdminPayments(payments) {
    console.log('displayAdminPayments called with:', payments);
    console.log('Payment count by status:', {
        total: payments.length,
        pending: payments.filter(p => p.status === 'pending').length,
        completed: payments.filter(p => p.status === 'completed').length,
        rejected: payments.filter(p => p.status === 'rejected').length
    });
    
    const adminPaymentList = document.getElementById('adminPaymentList');
    
    if (payments.length === 0) {
        adminPaymentList.innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-receipt" style="font-size: 3rem; color: #6c757d;"></i>
                <h5 class="mt-3">No Payments Found</h5>
                <p class="text-muted">No payments match the selected criteria.</p>
            </div>
        `;
        return;
    }
    
    // Group payments by user
    const paymentsByUser = {};
    payments.forEach(payment => {
        if (!paymentsByUser[payment.user_id]) {
            paymentsByUser[payment.user_id] = {
                user_id: payment.user_id,
                user_name: payment.user_name,
                user_email: payment.user_email,
                user_phone: payment.user_phone || 'Not provided',
                user_role: payment.user_role,
                payments: []
            };
        }
        paymentsByUser[payment.user_id].payments.push(payment);
    });
    
    // Create heading row first
    let headingHtml = `
        <div class="row align-items-center bg-light border-bottom py-2 fw-bold">
            <div class="col-md-1 text-center">S/NO</div>
            <div class="col-md-2">Name & ID</div>
            <div class="col-md-2">Email & Phone</div>
            <div class="col-md-2">Sender Name</div>
            <div class="col-md-2">Approved Amount</div>
            <div class="col-md-2">Status</div>
            <div class="col-md-1 text-center">Actions</div>
        </div>
    `;
    
    let html = headingHtml;
    
    Object.values(paymentsByUser).forEach(user => {
        // Calculate totals and status
        const totalAmount = user.payments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
        const pendingCount = user.payments.filter(p => p.status === 'pending').length;
        const completedCount = user.payments.filter(p => p.status === 'completed').length;
        const rejectedCount = user.payments.filter(p => p.status === 'rejected').length;
        
        // Create payment types display with better styling
        let paymentTypesHtml = '';
        let senderNames = new Set();
        user.payments.forEach(payment => {
            if (payment.sender_name) {
                senderNames.add(payment.sender_name);
            }
            
            const statusClass = payment.status === 'completed' ? 'success' : 
                              payment.status === 'pending' ? 'warning' : 'danger';
            const statusBadge = payment.status === 'completed' ? 'Completed' : 
                               payment.status === 'pending' ? 'Pending' : 'Rejected';
            
            paymentTypesHtml += `
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background-color: #f8f9fa; border-left: 4px solid #${statusClass === 'success' ? '28a745' : statusClass === 'warning' ? 'ffc107' : 'dc3545'};">
                    <div>
                        <div class="fw-bold text-primary">${getAdminPaymentTypeLabel(payment.payment_type)}</div>
                        <small class="text-muted">TZS ${parseInt(payment.amount).toLocaleString()}</small>
                    </div>
                    <span class="badge bg-${statusClass}">${statusBadge}</span>
                </div>
            `;
        });
        
        // Create sender names display
        const senderNamesList = Array.from(senderNames).join(', ') || 'Not provided';
        
        // Create status summary
        let statusSummary = '';
        if (pendingCount > 0) statusSummary += `<span class="badge bg-warning me-1">Pending: ${pendingCount}</span>`;
        if (completedCount > 0) statusSummary += `<span class="badge bg-success me-1">Completed: ${completedCount}</span>`;
        if (rejectedCount > 0) statusSummary += `<span class="badge bg-danger me-1">Rejected: ${rejectedCount}</span>`;
        
        html += `
            <div class="row align-items-center border-bottom py-2 admin-payment-row">
                <!-- Column 0: S/NO -->
                <div class="col-md-1 text-center">
                    <div class="fw-bold">${Object.keys(paymentsByUser).indexOf(String(user.user_id)) + 1}</div>
                </div>
                
                <!-- Column 1: Name & ID -->
                <div class="col-md-2">
                    <div class="fw-bold text-primary">TMCS-${String(user.user_id || '0000').padStart(4, '0')}</div>
                    <div class="fw-bold">${user.user_name}</div>
                </div>
                
                <!-- Column 2: Email & Phone -->
                <div class="col-md-2">
                    <div class="small text-muted">${user.user_email}</div>
                    <div class="small text-muted">${user.user_phone}</div>
                </div>
                
                <!-- Column 3: Sender Name -->
                <div class="col-md-2">
                    <div class="text-muted small">Sender Names</div>
                    <div class="fw-bold text-info">${senderNamesList}</div>
                </div>
                
                <!-- Column 4: Approved Amount -->
                <div class="col-md-2">
                    <div class="text-muted small">Approved Amount</div>
                    <div class="fw-bold text-success">TZS ${parseInt(user.payments.filter(p => p.status === 'completed').reduce((sum, p) => sum + parseFloat(p.amount || 0), 0)).toLocaleString()}</div>
                </div>
                
                <!-- Column 5: Status -->
                <div class="col-md-2">
                    ${statusSummary || '<span class="text-muted">No payments</span>'}
                </div>
                
                <!-- Column 6: Actions -->
                <div class="col-md-1 text-center">
                    <div class="admin-payment-actions">
                        <button class="btn btn-primary btn-sm" onclick="viewUserPaymentDetails('${user.user_id}')" title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                        ${pendingCount > 0 ? `
                            <button class="btn btn-success btn-sm" onclick="showApprovePaymentModal('${user.user_id}')" title="Approve Payment">
                                <i class="bi bi-check-circle"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="showRejectPaymentModal('${user.user_id}')" title="Reject Payment">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    });
    
    adminPaymentList.innerHTML = html;
}

function showRejectPaymentModal(userId) {
    // Find all pending payments for this user
    const userPayments = window.adminAllPayments.filter(p => p.user_id == userId && p.status === 'pending');
    if (userPayments.length === 0) return;
    
    const user = userPayments[0];
    
    // Create payment type options
    let paymentOptions = '';
    userPayments.forEach(payment => {
        paymentOptions += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="rejectPaymentType" value="${payment.id}" id="reject_payment_${payment.id}">
                <label class="form-check-label" for="reject_payment_${payment.id}">
                    <strong>${getAdminPaymentTypeLabel(payment.payment_type)}</strong> - TZS ${parseInt(payment.amount).toLocaleString()}
                </label>
            </div>
        `;
    });
    
    const modalHtml = `
        <div class="modal fade" id="rejectPaymentModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-x-circle me-2"></i>Reject Payment - TMCS-${String(userId).padStart(4, '0')}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6 class="text-primary">Member Information</h6>
                            <div class="fw-bold">${user.user_name}</div>
                            <div class="small text-muted">${user.user_email}</div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-primary">Select Payment to Reject</h6>
                            ${paymentOptions}
                        </div>
                        
                        <div class="mb-3">
                            <label for="rejectReason" class="form-label">Rejection Reason (Required)</label>
                            <textarea class="form-control" id="rejectReason" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="submitRejection()">
                            <i class="bi bi-x-circle me-1"></i>Reject Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('rejectPaymentModal');
    if (existingModal) existingModal.remove();
    
    // Add modal to body and show
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('rejectPaymentModal'));
    modal.show();
}

function submitRejection() {
    const selectedPayment = document.querySelector('input[name="rejectPaymentType"]:checked');
    const rejectReason = document.getElementById('rejectReason').value;
    
    if (!selectedPayment) {
        alert('Please select a payment to reject.');
        return;
    }
    
    if (!rejectReason.trim()) {
        alert('Please provide a reason for rejection.');
        return;
    }
    
    const paymentId = selectedPayment.value;
    
    // Reject payment with reason
    fetch(`/admin/payments/${paymentId}/reject`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            reason: rejectReason
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            loadAdminPayments();
            alert('Payment rejected successfully!');
            const modalElement = document.getElementById('rejectPaymentModal');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) modal.hide();
            }
        } else {
            alert('Error rejecting payment: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Error rejecting payment: ' + error.message);
    });
}

function showApprovePaymentModal(userId) {
    // Find all pending payments for this user
    const userPayments = window.adminAllPayments.filter(p => p.user_id == userId && p.status === 'pending');
    if (userPayments.length === 0) return;
    
    const user = userPayments[0];
    
    // Create payment type options
    let paymentOptions = '';
    userPayments.forEach(payment => {
        paymentOptions += `
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="paymentType" value="${payment.id}" id="payment_${payment.id}">
                <label class="form-check-label" for="payment_${payment.id}">
                    <strong>${getAdminPaymentTypeLabel(payment.payment_type)}</strong> - TZS ${parseInt(payment.amount).toLocaleString()}
                </label>
            </div>
        `;
    });
    
    const modalHtml = `
        <div class="modal fade" id="approvePaymentModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle me-2"></i>Approve Payment - TMCS-${String(userId).padStart(4, '0')}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6 class="text-primary">Member Information</h6>
                            <div class="fw-bold">${user.user_name}</div>
                            <div class="small text-muted">${user.user_email}</div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-primary">Select Payment to Approve</h6>
                            ${paymentOptions}
                        </div>
                        
                        <div class="mb-3">
                            <label for="approveComments" class="form-label">Comments (Optional)</label>
                            <textarea class="form-control" id="approveComments" rows="3" placeholder="Add any comments about this approval..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" onclick="submitApproval()">
                            <i class="bi bi-check-circle me-1"></i>Approve Selected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('approvePaymentModal');
    if (existingModal) existingModal.remove();
    
    // Add modal to body and show
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('approvePaymentModal'));
    modal.show();
}

function submitApproval() {
    const selectedPayment = document.querySelector('input[name="paymentType"]:checked');
    const comments = document.getElementById('approveComments').value;
    
    if (!selectedPayment) {
        alert('Please select a payment to approve.');
        return;
    }
    
    const paymentId = selectedPayment.value;
    
    // Approve the payment with comments
    fetch(`/admin/payments/${paymentId}/approve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            comments: comments
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            loadAdminPayments();
            alert('Payment approved successfully!');
            const modalElement = document.getElementById('approvePaymentModal');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) modal.hide();
            }
        } else {
            alert('Error approving payment: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Error approving payment: ' + error.message);
    });
}

function viewUserPaymentDetails(userId) {
    // Find all payments for this user
    const userPayments = window.adminAllPayments.filter(p => p.user_id == userId);
    if (userPayments.length === 0) return;
    
    const user = userPayments[0];
    
    // Group payments by year
    const paymentsByYear = {};
    userPayments.forEach(payment => {
        const year = payment.payment_year || 'Unknown';
        if (!paymentsByYear[year]) {
            paymentsByYear[year] = [];
        }
        paymentsByYear[year].push(payment);
    });
    
    // Create HTML for each year
    let paymentsHtml = '';
    Object.keys(paymentsByYear).sort((a, b) => b - a).forEach(year => {
        const yearPayments = paymentsByYear[year];
        // Calculate total amount for completed payments only
        const yearTotalCompleted = yearPayments.filter(p => p.status === 'completed').reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
        const yearTotalAll = yearPayments.reduce((sum, p) => sum + parseFloat(p.amount || 0), 0);
        const completedCount = yearPayments.filter(p => p.status === 'completed').length;
        
        paymentsHtml += `
            <div class="mb-4">
                <h6 class="text-primary mb-3">
                    <i class="bi bi-calendar me-2"></i>Year ${year}
                    <span class="badge bg-secondary ms-2">${yearPayments.length} payments</span>
                    <span class="badge bg-success ms-1">TZS ${yearTotalCompleted.toLocaleString()} (${completedCount} completed)</span>
                </h6>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Payment ID</th>
                                <th>Payment Type</th>
                                <th>Amount</th>
                                <th>Sender Name</th>
                                <th>Status</th>
                                <th>Date & Method</th>
                                <th>Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
        `;
        
        yearPayments.forEach(payment => {
            const statusClass = payment.status === 'completed' ? 'success' : 
                              payment.status === 'pending' ? 'warning' : 'danger';
            const statusBadge = payment.status === 'completed' ? 'Completed' : 
                               payment.status === 'pending' ? 'Pending' : 'Rejected';
            
            paymentsHtml += `
                <tr>
                    <td>${payment.id}</td>
                    <td>
                        <div class="fw-bold text-primary">${getAdminPaymentTypeLabel(payment.payment_type)}</div>
                        <small class="text-muted">Year: ${payment.payment_year || 'N/A'}</small>
                    </td>
                    <td><strong class="text-success">TZS ${parseInt(payment.amount).toLocaleString()}</strong></td>
                    <td>
                        <div class="fw-bold text-info">${payment.sender_name || 'Not provided'}</div>
                        <small class="text-muted">Payment sender</small>
                    </td>
                    <td><span class="badge bg-${statusClass}">${statusBadge}</span></td>
                    <td>
                        <div>${formatAdminDate(payment.created_at)}</div>
                        <small class="text-muted">Method: ${payment.payment_method || 'N/A'}</small>
                    </td>
                    <td>
                        ${payment.attachment ? `
                            <button class="btn btn-primary btn-sm" onclick="viewAttachmentInline('${payment.attachment}', '${getAdminPaymentTypeLabel(payment.payment_type)}')" title="View Attachment">
                                <i class="bi bi-paperclip me-1"></i>View
                            </button>
                        ` : '<span class="text-muted">No attachment</span>'}
                    </td>
                </tr>
            `;
        });
        
        paymentsHtml += `
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    });
    
    const modalHtml = `
        <div class="modal fade" id="userPaymentDetailsModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-person me-2"></i>Payment Details - TMCS-${String(userId).padStart(4, '0')}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-primary">Member Information</h6>
                                <table class="table table-sm table-borderless">
                                    <tr><td><strong>User ID:</strong></td><td>TMCS-${String(userId).padStart(4, '0')}</td></tr>
                                    <tr><td><strong>Name:</strong></td><td>${user.user_name}</td></tr>
                                    <tr><td><strong>Email:</strong></td><td>${user.user_email}</td></tr>
                                    <tr><td><strong>Phone:</strong></td><td>${user.user_phone || 'Not provided'}</td></tr>
                                    <tr><td><strong>Role:</strong></td><td><span class="badge bg-info">${user.user_role}</span></td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Payment Summary</h6>
                                <table class="table table-sm table-borderless">
                                    <tr><td><strong>Total Payments:</strong></td><td>${userPayments.length}</td></tr>
                                    <tr><td><strong>Total Amount:</strong></td><td><strong>TZS ${parseInt(userPayments.filter(p => p.status === 'completed').reduce((sum, p) => sum + parseFloat(p.amount || 0), 0)).toLocaleString()}</strong></td></tr>
                                    <tr><td><strong>Pending:</strong></td><td><span class="badge bg-warning">${userPayments.filter(p => p.status === 'pending').length}</span></td></tr>
                                    <tr><td><strong>Completed:</strong></td><td><span class="badge bg-success">${userPayments.filter(p => p.status === 'completed').length}</span></td></tr>
                                    <tr><td><strong>Rejected:</strong></td><td><span class="badge bg-danger">${userPayments.filter(p => p.status === 'rejected').length}</span></td></tr>
                                </table>
                            </div>
                        </div>
                        
                        ${paymentsHtml}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" onclick="generatePDFReport(${userId})">
                            <i class="bi bi-file-pdf me-1"></i>Generate PDF Report
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('userPaymentDetailsModal');
    if (existingModal) existingModal.remove();
    
    // Add modal to body and show
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('userPaymentDetailsModal'));
    modal.show();
}

function approveAllUserPayments(userId) {
    const userPayments = window.adminAllPayments.filter(p => p.user_id == userId && p.status === 'pending');
    if (userPayments.length === 0) {
        alert('No pending payments to approve for this user.');
        return;
    }
    
    if (!confirm(`Are you sure you want to approve all ${userPayments.length} pending payments for this user?`)) {
        return;
    }
    
    // Approve each payment
    let approvedCount = 0;
    userPayments.forEach(payment => {
        approvePayment(payment.id, false); // Pass false to avoid reload for each
        approvedCount++;
    });
    
    // Reload payments after all approvals
    setTimeout(() => {
        loadAdminPayments();
        alert(`Successfully approved ${approvedCount} payments!`);
    }, 1000);
}

function rejectAllUserPayments(userId) {
    const userPayments = window.adminAllPayments.filter(p => p.user_id == userId && p.status === 'pending');
    if (userPayments.length === 0) {
        alert('No pending payments to reject for this user.');
        return;
    }
    
    if (!confirm(`Are you sure you want to reject all ${userPayments.length} pending payments for this user?`)) {
        return;
    }
    
    // Reject each payment
    let rejectedCount = 0;
    userPayments.forEach(payment => {
        rejectPayment(payment.id, false); // Pass false to avoid reload for each
        rejectedCount++;
    });
    
    // Reload payments after all rejections
    setTimeout(() => {
        loadAdminPayments();
        alert(`Successfully rejected ${rejectedCount} payments!`);
    }, 1000);
}

function getAdminPaymentTypeLabel(type) {
    const labels = {
        'membership': 'Membership Fee',
        'certificate': 'Certificate Fee',
        'zaka': 'Zaka',
        'donation': 'Donation',
        'event': 'Event Registration',
        'other': 'Other'
    };
    return labels[type] || type;
}

function formatAdminDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function viewAttachmentInline(attachmentPath, paymentType) {
    // Create modal for attachment preview
    const modalHtml = `
        <div class="modal fade" id="attachmentPreviewModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background: #1e3a8a; color: white;">
                        <h6 class="modal-title mb-0">
                            <i class="bi bi-paperclip me-2"></i>Attachment Preview - ${paymentType}
                        </h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-3" style="max-height: 80vh; overflow: auto;">
                        <div class="attachment-preview-container">
                            <img src="/storage/${attachmentPath}" class="attachment-preview-image" alt="Attachment Preview" 
                                 style="max-width: 100%; max-height: 60vh; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                                 onerror="this.style.display='none'; document.getElementById('attachmentError').style.display='block';">
                            <div id="attachmentError" style="display: none;" class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Unable to load attachment preview
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="window.open('/storage/${attachmentPath}', '_blank')">
                                <i class="bi bi-download me-1"></i>Open in New Tab
                            </button>
                            <a href="/storage/${attachmentPath}" download class="btn btn-success btn-sm me-2">
                                <i class="bi bi-download me-1"></i>Download
                            </a>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('attachmentPreviewModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('attachmentPreviewModal'));
    modal.show();
    
    // Clean up modal after hidden
    document.getElementById('attachmentPreviewModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

function viewAttachment(attachmentPath) {
    // Open attachment in new tab for viewing
    const fullUrl = `/storage/${attachmentPath}`;
    window.open(fullUrl, '_blank');
}

function downloadAttachment(attachmentPath) {
    // Create a temporary link element to trigger download
    const fullUrl = `/storage/${attachmentPath}`;
    const link = document.createElement('a');
    link.href = fullUrl;
    link.download = attachmentPath.split('/').pop(); // Get filename from path
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function viewAdminPaymentDetails(paymentId) {
    // Find payment from global array
    const payment = window.adminAllPayments.find(p => p.id == paymentId);
    if (!payment) return;
    
    alert(`Payment Details:\n\nID: TMCS-${String(payment.user_id || '0000').padStart(4, '0')}\nMember: ${payment.user_name}\nType: ${getAdminPaymentTypeLabel(payment.payment_type)}\nAmount: TZS ${parseInt(payment.amount).toLocaleString()}\nStatus: ${payment.status}\nDate: ${formatAdminDate(payment.created_at)}\nMethod: ${payment.payment_method}\nSender: ${payment.sender_name}`);
}

function approvePayment(paymentId, reload = true) {
    if (confirm('Are you sure you want to approve this payment?')) {
        fetch(`/admin/payments/${paymentId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (reload) {
                    loadAdminPayments();
                }
                alert('Payment approved successfully!');
            } else {
                alert('Error approving payment: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error approving payment');
        });
    }
}

function rejectPayment(paymentId, reload = true) {
    if (confirm('Are you sure you want to reject this payment?')) {
        fetch(`/admin/payments/${paymentId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (reload) {
                    loadAdminPayments();
                }
                alert('Payment rejected successfully!');
            } else {
                alert('Error rejecting payment: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error rejecting payment');
        });
    }
}

function generatePDFReport(userId) {
    // Find all payments for this user
    const userPayments = window.adminAllPayments.filter(p => p.user_id == userId);
    if (userPayments.length === 0) {
        alert('No payments found for this user.');
        return;
    }
    
    const user = userPayments[0];
    
    // Create form data for PDF generation
    const formData = new FormData();
    formData.append('user_id', userId);
    formData.append('user_name', user.user_name);
    formData.append('user_email', user.user_email);
    formData.append('user_phone', user.user_phone);
    formData.append('user_role', user.user_role);
    formData.append('payments', JSON.stringify(userPayments));
    
    // Send request to generate PDF
    fetch('/admin/generate-payment-pdf', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            // Download the PDF
            return response.blob();
        } else {
            throw new Error('Failed to generate PDF');
        }
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `payment_report_TMCS${String(userId).padStart(4, '0')}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        
        // Show success message
        showSuccessNotification('PDF report generated successfully!');
    })
    .catch(error => {
        console.error('Error generating PDF:', error);
        showErrorNotification('Failed to generate PDF report. Please try again.');
    });
}

function showSuccessNotification(message) {
    // Create success notification
    const notification = document.createElement('div');
    notification.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

function showErrorNotification(message) {
    // Create error notification
    const notification = document.createElement('div');
    notification.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.innerHTML = `
        <i class="bi bi-exclamation-triangle-fill me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

function showReports() {
    hideAllSections();
    document.getElementById('reportsSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(event.target.closest('.list-group-item'));
}

function showMemberReports() {
    console.log('showMemberReports called');
    hideAllSections();
    document.getElementById('reportsSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    // Update active menu
    const menuItem = document.querySelector('[onclick="showMemberReports()"]');
    if (menuItem) {
        updateActiveMenu(menuItem);
    }
    
    // Show member reports interface
    showMemberReportsInterface();
}

function showGeneralReports() {
    console.log('showGeneralReports called');
    hideAllSections();
    document.getElementById('reportsSection').style.display = 'block';
    
    // Update active menu
    const menuItem = document.querySelector('[onclick="showGeneralReports()"]');
    if (menuItem) {
        updateActiveMenu(menuItem);
    }
    
    // Show general reports interface
    showGeneralReportsInterface();
}

function hideAllSections() {
    document.getElementById('addMemberForm').style.display = 'none';
    document.getElementById('manageUsersSection').style.display = 'none';
    document.getElementById('manageLeadersSection').style.display = 'none';
    document.getElementById('paymentAccountsSection').style.display = 'none';
    document.getElementById('announcementsSection').style.display = 'none';
    document.getElementById('makePaymentsSection').style.display = 'none';
    document.getElementById('memberPaymentsSection').style.display = 'none';
    document.getElementById('myProfileSection').style.display = 'none';
    document.getElementById('reportsSection').style.display = 'none';
}

function showAnnouncements() {
    hideAllSections();
    document.getElementById('announcementsSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(event.target.closest('.list-group-item'));
    loadAnnouncements();
}

function showMakePayments() {
    hideAllSections();
    document.getElementById('makePaymentsSection').style.display = 'block';
    
    // Close mobile sidebar if open
    const sidebar = document.getElementById('adminSidebarMenu');
    if (sidebar && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }
    
    updateActiveMenu(event.target.closest('.list-group-item'));
    resetAdminPaymentForm();
    
    // Load payment accounts for the dropdown
    loadPaymentAccountsForMakePayments();
}

function loadPaymentAccountsForMakePayments() {
    const paymentMethodSelect = document.getElementById('adminPaymentMethod');
    
    console.log('Loading payment accounts for make payments...');
    
    // Set loading state
    paymentMethodSelect.innerHTML = '<option value="">Loading payment methods...</option>';
    
    // Load real accounts from database
    fetch('/admin/payments/accounts')
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data);
            if (data.success && data.accounts && data.accounts.length > 0) {
                console.log('Accounts received:', data.accounts);
                populatePaymentMethodsFromAccounts(data.accounts);
            } else {
                console.log('No accounts found, using default options');
                populateDefaultPaymentMethods();
            }
        })
        .catch(error => {
            console.error('Error fetching payment accounts:', error);
            console.log('Using default options due to error');
            populateDefaultPaymentMethods();
        });
}

function populatePaymentMethodsFromAccounts(accounts) {
    console.log('populatePaymentMethodsFromAccounts called with:', accounts);
    const paymentMethodSelect = document.getElementById('adminPaymentMethod');
    
    // Clear existing options
    paymentMethodSelect.innerHTML = '<option value="">Select method...</option>';
    
    if (!accounts || accounts.length === 0) {
        console.log('No accounts found');
        paymentMethodSelect.innerHTML = '<option value="">No payment methods available</option>';
        return;
    }
    
    // Group accounts by type
    const mobileAccounts = accounts.filter(account => account.account_type === 'mobile');
    const bankAccounts = accounts.filter(account => account.account_type === 'bank');
    
    console.log('Mobile accounts:', mobileAccounts);
    console.log('Bank accounts:', bankAccounts);
    
    // Add Mobile Money accounts
    if (mobileAccounts.length > 0) {
        mobileAccounts.forEach(account => {
            paymentMethodSelect.innerHTML += `<option value="mobile_${account.id}">Mobile: ${account.account_name} (${account.account_number})</option>`;
        });
    }
    
    // Add Bank Transfer accounts
    if (bankAccounts.length > 0) {
        bankAccounts.forEach(account => {
            paymentMethodSelect.innerHTML += `<option value="bank_${account.id}">Bank: ${account.account_name} (${account.account_number})</option>`;
        });
    }
    
    // If no accounts found, show message
    if (mobileAccounts.length === 0 && bankAccounts.length === 0) {
        paymentMethodSelect.innerHTML = '<option value="">No payment methods available</option>';
    }
    
    console.log('Final dropdown HTML:', paymentMethodSelect.innerHTML);
}

function populateDefaultPaymentMethods() {
    console.log('populateDefaultPaymentMethods called!');
    const paymentMethodSelect = document.getElementById('adminPaymentMethod');
    
    if (!paymentMethodSelect) {
        console.error('adminPaymentMethod element not found!');
        return;
    }
    
    // No default options - only database accounts should be shown
    paymentMethodSelect.innerHTML = `
        <option value="">No payment methods available</option>
    `;
    
    console.log('Default options populated. Current HTML:', paymentMethodSelect.innerHTML);
}

function loadAnnouncements() {
    console.log('Loading announcements...');
    fetch('/admin/announcements')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayAnnouncements(data.announcements);
            } else {
                console.error('Failed to load announcements:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading announcements:', error);
        });
}

function displayAnnouncements(announcements) {
    const container = document.getElementById('announcementsList');
    
    if (!announcements || announcements.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-megaphone display-1 text-muted mb-3"></i>
                <h5>No Announcements Yet</h5>
                <p class="text-muted">Start by creating your first announcement above.</p>
            </div>
        `;
        return;
    }
    
    let html = '';
    announcements.forEach(announcement => {
        const priorityClass = announcement.priority === 'urgent' ? 'danger' : 
                             announcement.priority === 'important' ? 'warning' : 'primary';
        const priorityBadge = announcement.priority === 'urgent' ? 'Urgent' : 
                             announcement.priority === 'important' ? 'Important' : 'Normal';
        
        html += `
            <div class="card mb-3 border-${priorityClass}">
                <div class="card-header bg-${priorityClass} text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi bi-megaphone-fill me-2"></i>${announcement.title}
                        </h6>
                        <div>
                            <span class="badge bg-light text-${priorityClass}">${priorityBadge}</span>
                            <span class="badge bg-light text-${priorityClass} ms-1">${announcement.audience}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    ${announcement.image ? `
                        <div class="announcement-image-container">
                            <img src="/storage/${announcement.image}" alt="Announcement Image" class="announcement-image-display">
                        </div>
                    ` : ''}
                    <p class="card-text">${announcement.message}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-person me-1"></i>${announcement.created_by}
                            <i class="bi bi-calendar ms-3 me-1"></i>${formatDate(announcement.created_at)}
                            ${announcement.expiry_date ? `<i class="bi bi-clock ms-3 me-1"></i>Expires: ${formatDate(announcement.expiry_date)}` : ''}
                            ${announcement.image ? `<i class="bi bi-image ms-3 me-1"></i>Has Image` : ''}
                        </small>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary" onclick="editAnnouncement(${announcement.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteAnnouncement(${announcement.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function clearAnnouncementForm() {
    document.getElementById('createAnnouncementForm').reset();
    clearAnnouncementImage();
}

function viewRecentAnnouncements() {
    // Create and show modal for recent announcements
    const modalHtml = `
        <div class="modal fade" id="recentAnnouncementsModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary text-white py-3 border-0">
                        <h5 class="modal-title fs-5 mb-0 d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-megaphone-fill fs-6"></i>
                            </div>
                            <span class="fw-semibold">Latest Announcements</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body py-3">
                        <div class="text-center py-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                <i class="bi bi-megaphone-fill fs-3 text-primary"></i>
                            </div>
                            <h6 class="text-primary mb-2 fw-semibold">Loading Announcements</h6>
                            <p class="text-muted small mb-3">Fetching latest announcements...</p>
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0 py-3">
                        <button type="button" class="btn btn-secondary rounded-2 px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Close
                        </button>
                        <button type="button" class="btn btn-primary rounded-2 px-4" onclick="location.href='#announcementsSection'">
                            <i class="bi bi-plus-circle me-1"></i>Create New
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('recentAnnouncementsModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('recentAnnouncementsModal'));
    modal.show();
    
    // Fetch recent announcements
    fetch('/admin/announcements')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayRecentAnnouncements(data.announcements);
            } else {
                console.error('Failed to load recent announcements:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading recent announcements:', error);
        });
}

function displayRecentAnnouncements(announcements) {
    const modalBody = document.querySelector('#recentAnnouncementsModal .modal-body');
    
    if (!announcements || announcements.length === 0) {
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="bg-white rounded-4 p-4 shadow-sm border border-light">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-megaphone-slash fs-3 text-primary"></i>
                    </div>
                    <h6 class="text-primary mb-2 fw-semibold">No Announcements Yet</h6>
                    <p class="text-muted small mb-3">Start by creating your first announcement</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                            <i class="bi bi-plus-circle me-1"></i>Create New
                        </span>
                        <span class="badge bg-light text-secondary px-3 py-2">
                            <i class="bi bi-info-circle me-1"></i>Get Started
                        </span>
                    </div>
                </div>
            </div>
        `;
        return;
    }
    
    // Display announcements in a full-width layout
    let html = '<div class="row g-3">';
    announcements.slice(0, 6).forEach((announcement, index) => {
        const priorityClass = announcement.priority === 'urgent' ? 'danger' : 
                             announcement.priority === 'important' ? 'warning' : 'primary';
        const priorityBadge = announcement.priority === 'urgent' ? 'Urgent' : 
                             announcement.priority === 'important' ? 'Important' : 'Normal';
        
        const createdDate = new Date(announcement.created_at).toLocaleDateString();
        
        html += `
            <div class="col-12">
                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold text-truncate" style="max-width: 400px;">
                                ${announcement.title}
                            </h5>
                            <span class="badge bg-white bg-opacity-20 text-white fs-6">
                                <i class="bi bi-flag-fill me-1"></i>${priorityBadge}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            ${announcement.image && announcement.image.trim() !== '' ? `
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="position-relative">
                                        <img src="${announcement.image}" alt="Announcement Image" class="img-fluid rounded-3 shadow-sm w-100" style="max-height: 200px; object-fit: cover;" 
                                             onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'bg-light rounded-3 d-flex align-items-center justify-content-center\' style=\'width: 100%; height: 200px;\'><div class=\'text-center\'><i class=\'bi bi-image text-muted fs-1 mb-2\'></i><p class=\'text-muted small mb-0\'>Image not available</p></div></div>';">
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <button type="button" class="btn btn-primary btn-sm rounded-circle shadow-lg" onclick="viewAnnouncementImage('${announcement.image}', '${announcement.title}')" style="opacity: 0.9;">
                                                <i class="bi bi-zoom-in"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                            ` : `
                                <div class="col-12">
                            `}
                                <p class="text-muted mb-3" style="line-height: 1.6;">
                                    ${announcement.message}
                                </p>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-event me-1"></i>${createdDate}
                                    </small>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-primary rounded-2 px-3 py-2" onclick="editAnnouncement(${announcement.id})">
                                            <i class="bi bi-pencil-fill me-1"></i>Edit
                                        </button>
                                        <button type="button" class="btn btn-outline-danger rounded-2 px-3 py-2" onclick="deleteAnnouncement(${announcement.id})">
                                            <i class="bi bi-trash-fill me-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    
    // Add "Show More" button if more than 6 announcements
    if (announcements.length > 6) {
        html += `
            <div class="text-center mt-3">
                <button type="button" class="btn btn-outline-info" onclick="showAllAnnouncements()">
                    <i class="bi bi-arrow-down-circle me-2"></i>Show All Announcements (${announcements.length})
                </button>
            </div>
        `;
    }
    
    modalBody.innerHTML = html;
}

function showAllAnnouncements() {
    // Close recent modal and load all announcements in main view
    const modal = bootstrap.Modal.getInstance(document.getElementById('recentAnnouncementsModal'));
    modal.hide();
    
    // You could redirect to a full announcements page or show a larger list
    alert('Showing all announcements feature coming soon!');
}

function clearAnnouncementImage() {
    const fileInput = document.getElementById('announcementImage');
    const preview = document.getElementById('announcementImagePreview');
    const placeholder = document.getElementById('announcementUploadPlaceholder');
    
    fileInput.value = '';
    preview.style.display = 'none';
    placeholder.style.display = 'block';
}

// Add image upload functionality
document.addEventListener('DOMContentLoaded', function() {
    const imageUploadArea = document.getElementById('announcementImageUploadArea');
    const fileInput = document.getElementById('announcementImage');
    const preview = document.getElementById('announcementImagePreview');
    const placeholder = document.getElementById('announcementUploadPlaceholder');
    
    if (imageUploadArea && fileInput) {
        // Click to upload
        imageUploadArea.addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON') {
                fileInput.click();
            }
        });
        
        // File selection
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleAnnouncementImageUpload(file);
            }
        });
        
        // Drag and drop
        imageUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        imageUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        imageUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    handleAnnouncementImageUpload(file);
                } else {
                    alert('Please select an image file (PNG, JPG, GIF)');
                }
            }
        });
    }
});

function handleAnnouncementImageUpload(file) {
    // Check file size (2MB limit)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size must be less than 2MB');
        return;
    }
    
    // Check file type
    if (!file.type.match('image.*')) {
        alert('Please select an image file (PNG, JPG, GIF)');
        return;
    }
    
    // Preview the image
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('announcementImagePreview');
        const placeholder = document.getElementById('announcementUploadPlaceholder');
        const previewImg = preview.querySelector('img');
        
        previewImg.src = e.target.result;
        preview.style.display = 'flex';
        placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

// Add form submit handler for announcements
document.addEventListener('DOMContentLoaded', function() {
    const announcementForm = document.getElementById('createAnnouncementForm');
    if (announcementForm) {
        announcementForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Publishing...';
            submitBtn.disabled = true;
            
            fetch('/admin/announcements', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Announcement published successfully!');
                    clearAnnouncementForm();
                    loadAnnouncements();
                } else {
                    alert('Error: ' + (data.message || 'Failed to publish announcement'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error publishing announcement. Please try again.');
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

function editAnnouncement(id) {
    // Fetch announcement data
    fetch(`/admin/announcements/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const announcement = data.announcement;
                
                // Populate form fields
                document.getElementById('editAnnouncementId').value = announcement.id;
                document.getElementById('editAnnouncementTitle').value = announcement.title;
                document.getElementById('editAnnouncementPriority').value = announcement.priority;
                document.getElementById('editAnnouncementAudience').value = announcement.audience;
                document.getElementById('editAnnouncementExpiry').value = announcement.expiry_date || '';
                document.getElementById('editAnnouncementMessage').value = announcement.message;
                
                // Handle current image
                const currentImagePreview = document.getElementById('editCurrentImagePreview');
                const currentImage = currentImagePreview.querySelector('img');
                
                if (announcement.image) {
                    currentImage.src = `/storage/${announcement.image}`;
                    currentImagePreview.style.display = 'block';
                    document.getElementById('removeCurrentImage').checked = false;
                } else {
                    currentImagePreview.style.display = 'none';
                }
                
                // Clear new image preview
                clearEditAnnouncementImage();
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editAnnouncementModal'));
                modal.show();
            } else {
                alert('Error: ' + (data.message || 'Failed to load announcement'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading announcement. Please try again.');
        });
}

function updateAnnouncement() {
    const form = document.getElementById('editAnnouncementForm');
    const formData = new FormData(form);
    const announcementId = document.getElementById('editAnnouncementId').value;
    
    // Debug: Log form data
    console.log('Updating announcement ID:', announcementId);
    console.log('Form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    // Add method override for PUT
    formData.append('_method', 'PUT');
    
    // Add remove current image flag if checked
    if (document.getElementById('removeCurrentImage').checked) {
        formData.append('remove_current_image', '1');
        console.log('Adding remove_current_image flag');
    }
    
    const updateBtn = document.querySelector('#editAnnouncementModal .btn-warning');
    const originalText = updateBtn.innerHTML;
    
    // Show loading state
    updateBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Updating...';
    updateBtn.disabled = true;
    
    fetch(`/admin/announcements/${announcementId}`, {
        method: 'POST', // Use POST with _method override
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            alert('Announcement updated successfully!');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editAnnouncementModal'));
            modal.hide();
            
            // Reload announcements
            loadAnnouncements();
        } else {
            alert('Error: ' + (data.message || 'Failed to update announcement'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating announcement. Please try again.');
    })
    .finally(() => {
        // Restore button state
        updateBtn.innerHTML = originalText;
        updateBtn.disabled = false;
    });
}

function clearEditAnnouncementImage() {
    const fileInput = document.getElementById('editAnnouncementImage');
    const preview = document.getElementById('editAnnouncementImagePreview');
    const placeholder = document.getElementById('editAnnouncementUploadPlaceholder');
    
    fileInput.value = '';
    preview.style.display = 'none';
    placeholder.style.display = 'block';
}

// Add edit image upload functionality
document.addEventListener('DOMContentLoaded', function() {
    const editImageUploadArea = document.getElementById('editAnnouncementImageUploadArea');
    const editFileInput = document.getElementById('editAnnouncementImage');
    const editPreview = document.getElementById('editAnnouncementImagePreview');
    const editPlaceholder = document.getElementById('editAnnouncementUploadPlaceholder');
    
    if (editImageUploadArea && editFileInput) {
        // Click to upload
        editImageUploadArea.addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON') {
                editFileInput.click();
            }
        });
        
        // File selection
        editFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleEditAnnouncementImageUpload(file);
            }
        });
        
        // Drag and drop
        editImageUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        editImageUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        editImageUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    handleEditAnnouncementImageUpload(file);
                } else {
                    alert('Please select an image file (PNG, JPG, GIF)');
                }
            }
        });
    }
});

function handleEditAnnouncementImageUpload(file) {
    // Check file size (2MB limit)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size must be less than 2MB');
        return;
    }
    
    // Check file type
    if (!file.type.match('image.*')) {
        alert('Please select an image file (PNG, JPG, GIF)');
        return;
    }
    
    // Preview the image
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('editAnnouncementImagePreview');
        const placeholder = document.getElementById('editAnnouncementUploadPlaceholder');
        const previewImg = preview.querySelector('img');
        
        previewImg.src = e.target.result;
        preview.style.display = 'flex';
        placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function deleteAnnouncement(id) {
    if (confirm('Are you sure you want to delete this announcement?')) {
        fetch(`/admin/announcements/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Announcement deleted successfully!');
                loadAnnouncements();
            } else {
                alert('Error: ' + (data.message || 'Failed to delete announcement'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting announcement. Please try again.');
        });
    }
}

function loadMyProfile() {
    console.log('loadMyProfile called - using cached data first');
    
    // Use cached user data immediately for fast display
    const currentUser = @json(auth()->user());
    if (currentUser) {
        console.log('Using cached user data for immediate display');
        displayMyProfile(currentUser);
        
        // Then fetch fresh data in background to update if needed
        fetch('{{ route("admin.current-user") }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Background refresh response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Background refresh response data:', data);
            if (data.success) {
                // Only update if data is different
                displayMyProfile(data.user);
            }
        })
        .catch(error => {
            console.error('Error in background refresh:', error);
            // Don't show error to user since we already displayed cached data
        });
    } else {
        // Fallback to API call if no cached data
        console.log('No cached data, fetching from server');
        fetch('{{ route("admin.current-user") }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('loadMyProfile response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('loadMyProfile response data:', data);
            if (data.success) {
                displayMyProfile(data.user);
            } else {
                document.getElementById('profileContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Failed to load profile
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading profile:', error);
            document.getElementById('profileContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Error loading profile
                </div>
            `;
        });
    }
}

function displayMyProfile(user) {
    // Debug: Log user data
    console.log('=== PROFILE DEBUG ===');
    console.log('User data:', user);
    console.log('Profile picture path:', user.profile_picture);
    console.log('Profile picture exists:', !!user.profile_picture);
    
    if (user.profile_picture) {
        const imageUrl = "/uploads/profiles/" + user.profile_picture;
        console.log('Full image URL:', imageUrl);
        console.log('Image URL accessible:', imageUrl);
        
        // Test if image loads
        const testImg = new Image();
        testImg.onload = function() {
            console.log('Image loads successfully:', imageUrl);
        };
        testImg.onerror = function() {
            console.error('Image fails to load:', imageUrl);
        };
        testImg.src = imageUrl;
    }
    console.log('==================');
    
    const profileHtml = `
        <div class="row">
            <!-- Profile Picture Section -->
            <div class="col-md-4 text-center">
                <div class="profile-section">
                    ${user.profile_picture ? 
                        `<img src="/uploads/profiles/${user.profile_picture}" class="img-fluid rounded-circle mb-3" style="max-width: 150px; height: 150px; object-fit: cover;" alt="Profile Picture" onerror="this.onerror=null; this.src='/uploads/profiles/default-avatar.svg'; console.log('Profile image failed to load, using fallback:', this.src);">` :
                        `<div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; margin: 0 auto;">
                            <i class="bi bi-person fs-1 text-muted"></i>
                        </div>`
                    }
                    <h6 class="text-primary">TMCS-${String(user.id).padStart(4, '0')}</h6>
                    <p class="text-muted small">${user.name}</p>
                    <span class="badge bg-${user.role === 'admin' ? 'danger' : user.role === 'leader' ? 'warning' : 'primary'} badge-sm">
                        ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                    </span>
                    <span class="badge bg-${user.membership_status === 'Active' ? 'success' : 'secondary'} badge-sm ms-1">
                        ${user.membership_status}
                    </span>
                    
                    <div class="mt-3">
                        <button type="button" class="btn btn-warning btn-sm" onclick="editMyProfile(${user.id})" id="editProfileBtn">
                            <i class="bi bi-pencil me-1"></i>Edit Profile
                        </button>
                        <button type="button" class="btn btn-info btn-sm ms-2" onclick="changePassword(${user.id})">
                            <i class="bi bi-key me-1"></i>Change Password
                        </button>
                        <button type="button" class="btn btn-primary btn-sm ms-2" onclick="changeProfilePicture(${user.id})">
                            <i class="bi bi-camera me-1"></i>Change Photo
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Profile Details Section -->
            <div class="col-md-8">
                <div class="details-section">
                    <!-- Personal Information -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-person-fill me-2"></i>Personal Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>User ID:</strong><br>
                                <span class="text-muted">TMCS-${String(user.id).padStart(4, '0')}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Full Name:</strong><br>
                                <span class="text-muted">${user.name || 'Not set'}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Gender:</strong><br>
                                <span class="text-muted">${user.gender || 'Not set'}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Registration Number:</strong><br>
                                <span class="text-muted">${user.registration_number || 'Not set'}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Year of Study:</strong><br>
                                <span class="text-muted">${user.year_of_study || 'Not set'}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Home Diocese:</strong><br>
                                <span class="text-muted">${user.home_diocese || 'Not set'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-telephone-fill me-2"></i>Contact Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Email Address:</strong><br>
                                <span class="text-muted">${user.email || 'Not set'}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Phone Number:</strong><br>
                                <span class="text-muted">${user.phone_number || 'Not set'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Information -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="bi bi-shield-lock me-2"></i>Account Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>User ID:</strong><br>
                                <span class="text-muted">TMCS-${String(user.id).padStart(4, '0')}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Account Status:</strong><br>
                                <span class="badge bg-${user.membership_status === 'Active' ? 'success' : 'secondary'} badge-sm">
                                    ${user.membership_status}
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Account Created:</strong><br>
                                <span class="text-muted">${new Date(user.created_at).toLocaleDateString()}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Last Updated:</strong><br>
                                <span class="text-muted">${user.updated_at ? new Date(user.updated_at).toLocaleDateString() : 'Never'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('profileContent').innerHTML = profileHtml;
}

function editMyProfile(userId) {
    // Debug: Log when function is called
    console.log('editMyProfile called with userId:', userId);
    
    // Load current user details for editing
    fetch('/admin/users/' + userId + '/details', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showEditProfileModal(data.user);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to load profile for editing. Please try again.');
    });
}

function showEditProfileModal(user) {
    // Debug: Log when function is called
    console.log('showEditProfileModal called with user:', user);
    
    // Create edit profile modal HTML
    const editModalHtml = `
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-square me-2"></i>Edit My Profile - TMCS-${String(user.id).padStart(4, '0')}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProfileForm" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="${user.id}">
                            <input type="hidden" name="role" value="${user.role || 'member'}">
                            <input type="hidden" name="membership_status" value="${user.membership_status || 'Active'}">
                            
                            <!-- Profile Picture Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-camera me-2"></i>Profile Picture
                                    </h6>
                                </div>
                                
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Profile Picture</label>
                                    <div class="text-center">
                                        <div class="profile-upload-area mb-2" id="editProfileUploadArea">
                                            <div id="editProfilePreviewContainer">
                                                ${user.profile_picture ? 
                                                    `<img src="/uploads/profiles/${user.profile_picture}" class="img-fluid rounded-circle" style="max-width: 80px; height: 80px; object-fit: cover;" alt="Current Profile">` :
                                                    `<div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                                                        <i class="bi bi-person fs-3 text-muted"></i>
                                                    </div>`
                                                }
                                            </div>
                                            <img id="editProfilePreviewImage" class="img-fluid rounded-circle d-none" style="max-width: 80px; height: 80px; object-fit: cover;" alt="Profile Preview">
                                        </div>
                                        <input type="file" name="profile_picture" id="editProfilePicture" accept="image/*" class="d-none">
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-2">
                                    <label for="edit_profile_user_id" class="form-label">User ID</label>
                                    <input type="text" class="form-control" id="edit_profile_user_id" 
                                           value="TMCS-${String(user.id).padStart(4, '0')}" readonly>
                                </div>
                                
                                <div class="col-md-4 mb-2">
                                    <label for="edit_profile_name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="edit_profile_name" 
                                           value="${user.name || ''}" required>
                                </div>
                            </div>
                            
                            <!-- Personal Information Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-person-fill me-2"></i>Personal Information
                                    </h6>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_profile_registration_number" class="form-label">Registration Number</label>
                                    <input type="text" name="registration_number" class="form-control" id="edit_profile_registration_number" 
                                           value="${user.registration_number || ''}" placeholder="e.g., TMCS/2024/001">
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_profile_gender" class="form-label">Gender</label>
                                    <select name="gender" class="form-select" id="edit_profile_gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" ${user.gender === 'Male' ? 'selected' : ''}>Male</option>
                                        <option value="Female" ${user.gender === 'Female' ? 'selected' : ''}>Female</option>
                                        <option value="Other" ${user.gender === 'Other' ? 'selected' : ''}>Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_profile_year_of_study" class="form-label">Year of Study</label>
                                    <select name="year_of_study" class="form-select" id="edit_profile_year_of_study">
                                        <option value="">Select Year</option>
                                        <option value="Year 1" ${user.year_of_study === 'Year 1' ? 'selected' : ''}>Year 1</option>
                                        <option value="Year 2" ${user.year_of_study === 'Year 2' ? 'selected' : ''}>Year 2</option>
                                        <option value="Year 3" ${user.year_of_study === 'Year 3' ? 'selected' : ''}>Year 3</option>
                                        <option value="Year 4" ${user.year_of_study === 'Year 4' ? 'selected' : ''}>Year 4</option>
                                        <option value="Year 5" ${user.year_of_study === 'Year 5' ? 'selected' : ''}>Year 5</option>
                                        <option value="Graduate" ${user.year_of_study === 'Graduate' ? 'selected' : ''}>Graduate</option>
                                        <option value="Staff" ${user.year_of_study === 'Staff' ? 'selected' : ''}>Staff</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_profile_home_diocese" class="form-label">Home Diocese</label>
                                    <input type="text" name="home_diocese" class="form-control" id="edit_profile_home_diocese" 
                                           value="${user.home_diocese || ''}" required>
                                </div>
                            </div>
                            
                            <!-- Contact Information Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-telephone-fill me-2"></i>Contact Information
                                    </h6>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_profile_email" class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="edit_profile_email" 
                                           value="${user.email || ''}" required>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_profile_phone_number" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="tel" name="phone_number" class="form-control" id="edit_profile_phone_number" 
                                               value="${user.phone_number || ''}" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-warning" onclick="updateMyProfile()">
                            <i class="bi bi-check-circle me-2"></i>Update Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Debug: Check if Bootstrap is loaded
    console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
    console.log('Modal HTML created:', editModalHtml.length, 'characters');
    
    // Remove existing modal if any
    const existingModal = document.getElementById('editProfileModal');
    if (existingModal) {
        console.log('Removing existing modal');
        existingModal.remove();
    }
    
    // Add modal to body and show it
    document.body.insertAdjacentHTML('beforeend', editModalHtml);
    console.log('Modal added to body');
    
    const modalElement = document.getElementById('editProfileModal');
    console.log('Modal element found:', modalElement);
    
    try {
        const modal = new bootstrap.Modal(modalElement);
        console.log('Bootstrap modal created:', modal);
        modal.show();
        console.log('Modal show() called');
        
        // Fallback: Try jQuery method if Bootstrap doesn't work
        setTimeout(() => {
            if (!modalElement.classList.contains('show')) {
                console.log('Bootstrap modal not showing, trying jQuery fallback');
                if (typeof $ !== 'undefined') {
                    $(modalElement).modal('show');
                } else {
                    console.error('jQuery not available either');
                }
            }
        }, 1000);
        
    } catch (error) {
        console.error('Error creating/showing modal:', error);
        
        // Try manual modal display as last resort
        try {
            modalElement.style.display = 'block';
            modalElement.classList.add('show');
            document.body.classList.add('modal-open');
            
            // Create backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
            
            console.log('Manual modal display attempted');
            alert('⚠️ Modal opened manually. Please check Bootstrap loading.');
        } catch (manualError) {
            console.error('Manual modal display failed:', manualError);
            alert('❌ Error opening edit modal: ' + error.message);
        }
    }
    
    // Initialize edit profile picture upload
    initializeEditProfileUpload();
    
    // Clean up modal when hidden
    document.getElementById('editProfileModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

function initializeEditProfileUpload() {
    const fileInput = document.getElementById('editProfilePicture');
    const uploadArea = document.getElementById('editProfileUploadArea');
    const previewContainer = document.getElementById('editProfilePreviewContainer');
    const previewImage = document.getElementById('editProfilePreviewImage');

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleEditProfileFile(file);
        }
    });

    // Drag and drop handlers
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleEditProfileFile(files[0]);
        }
    });
}

function handleEditProfileFile(file) {
    console.log('handleEditProfileFile called with file:', file.name);
    
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

    // Get the elements
    const previewContainer = document.getElementById('editProfilePreviewContainer');
    const previewImage = document.getElementById('editProfilePreviewImage');
    const uploadArea = document.getElementById('editProfileUploadArea');
    const clearBtn = document.getElementById('clearPhotoBtn');
    const fileNameDiv = document.getElementById('selectedFileName');
    const fileNameText = document.getElementById('fileNameText');
    
    console.log('Preview elements found:', {
        previewContainer: !!previewContainer,
        previewImage: !!previewImage,
        uploadArea: !!uploadArea,
        clearBtn: !!clearBtn,
        fileNameDiv: !!fileNameDiv,
        fileNameText: !!fileNameText
    });

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        console.log('File reader loaded, setting preview');
        previewImage.src = e.target.result;
        previewContainer.style.display = 'none';
        previewImage.classList.remove('d-none');
        uploadArea.style.border = '2px solid #6c5ce7';
        uploadArea.style.background = 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)';
        
        // Show clear button and file name
        clearBtn.classList.remove('d-none');
        fileNameDiv.style.display = 'block';
        fileNameText.textContent = file.name;
    };
    reader.readAsDataURL(file);
}

function clearEditProfilePhoto() {
    console.log('clearEditProfilePhoto called');
    
    // Get the elements
    const previewContainer = document.getElementById('editProfilePreviewContainer');
    const previewImage = document.getElementById('editProfilePreviewImage');
    const uploadArea = document.getElementById('editProfileUploadArea');
    const clearBtn = document.getElementById('clearPhotoBtn');
    const fileNameDiv = document.getElementById('selectedFileName');
    const fileInput = document.getElementById('editProfilePicture');
    
    // Reset the preview
    previewImage.classList.add('d-none');
    previewContainer.style.display = 'block';
    uploadArea.style.border = '2px dashed #dee2e6';
    uploadArea.style.background = '#f8f9fa';
    
    // Hide clear button and file name
    clearBtn.classList.add('d-none');
    fileNameDiv.style.display = 'none';
    
    // Clear the file input
    fileInput.value = '';
    
    console.log('Profile photo preview cleared');
}

function updateMyProfile() {
    const form = document.getElementById('editProfileForm');
    const formData = new FormData(form);
    
    // Validate form
    const name = formData.get('name');
    const email = formData.get('email');
    const phone = formData.get('phone_number');
    
    if (!name || !email || !phone) {
        alert('❌ Please fill in all required fields');
        return;
    }
    
    // Make AJAX request with FormData for file upload support
    fetch('{{ route("admin.users.update") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('updateMyProfile response:', data);
        if (data.success) {
            alert('✅ ' + data.message);
            bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
            
            console.log('Calling loadMyProfile for refresh');
            // Reload profile data
            loadMyProfile();
            
            console.log('Calling refreshNavigationProfile after 500ms');
            // Refresh navigation profile picture if it was updated
            setTimeout(() => {
                refreshNavigationProfile();
            }, 500);
            
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to update profile. Please try again.');
    });
}

function refreshNavigationProfile() {
    console.log('refreshNavigationProfile called');
    
    // Show loading indicator
    const profileImg = document.querySelector('.profile-img');
    if (profileImg && profileImg.tagName === 'IMG') {
        profileImg.style.opacity = '0.5';
        console.log('Profile img found, setting opacity to 0.5');
    } else {
        console.log('Profile img not found or not an image tag');
    }
    
    // Refresh the current user data to update navigation profile picture
    fetch('{{ route("admin.current-user") }}', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Current user response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Current user response data:', data);
        if (data.success && data.user.profile_picture) {
            // Update navigation profile picture with cache busting
            const profileImg = document.querySelector('.profile-img');
            if (profileImg && profileImg.tagName === 'IMG') {
                const newSrc = '/uploads/profiles/' + data.user.profile_picture + '?t=' + Date.now();
                console.log('Updating profile img src to:', newSrc);
                profileImg.src = newSrc;
                profileImg.style.opacity = '1';
            }
        } else {
            console.log('No profile picture in response or success is false');
        }
    })
    .catch(error => {
        console.error('Error refreshing navigation profile:', error);
        // Restore opacity on error
        if (profileImg && profileImg.tagName === 'IMG') {
            profileImg.style.opacity = '1';
        }
    });
}

function changePassword(userId) {
    // Create change password modal
    const passwordModalHtml = `
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-key me-2"></i>Change Password - TMCS-${String(userId).padStart(4, '0')}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="changePasswordForm">
                            <input type="hidden" name="user_id" value="${userId}">
                            
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" id="current_password" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password" required minlength="6">
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-info" onclick="updatePassword()">
                            <i class="bi bi-check-circle me-2"></i>Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('changePasswordModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body and show it
    document.body.insertAdjacentHTML('beforeend', passwordModalHtml);
    const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
    
    // Clean up modal when hidden
    document.getElementById('changePasswordModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

function updatePassword() {
    const form = document.getElementById('changePasswordForm');
    const formData = new FormData(form);
    
    // Validate form
    const currentPassword = formData.get('current_password');
    const newPassword = formData.get('new_password');
    const confirmPassword = formData.get('new_password_confirmation');
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('❌ Please fill in all password fields');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('❌ New passwords do not match');
        return;
    }
    
    if (newPassword.length < 6) {
        alert('❌ Password must be at least 6 characters');
        return;
    }
    
    // Convert to JSON for AJAX
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    
    // Make AJAX request
    fetch('{{ route("admin.change-password") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to change password. Please try again.');
    });
}

function changeProfilePicture(userId) {
    // Create change profile picture modal
    const pictureModalHtml = `
        <div class="modal fade" id="changeProfilePictureModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-camera me-2"></i>Change Profile Picture - TMCS-${String(userId).padStart(4, '0')}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="changeProfilePictureForm" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="${userId}">
                            
                            <div class="text-center mb-4">
                                <div class="profile-upload-area" id="adminProfileUploadArea">
                                    <div id="adminPreviewContainer">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; margin: 0 auto;">
                                            <i class="bi bi-cloud-upload fs-4 text-muted"></i>
                                        </div>
                                        <h6 class="text-muted small">Click to upload photo</h6>
                                        <p class="text-muted small">or drag & drop</p>
                                        <button type="button" class="btn btn-primary btn-sm" id="adminChooseFileBtn">
                                            <i class="bi bi-folder2-open me-1"></i>Choose Photo
                                        </button>
                                        <p class="text-muted mt-1 mb-0 small">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                    <img id="adminPreviewImage" class="img-fluid rounded-circle d-none" style="max-width: 120px; height: 120px; object-fit: cover;" alt="Profile Preview">
                                </div>
                                <input type="file" name="profile_picture" id="adminProfilePicture" accept="image/*" class="d-none">
                                
                                <div class="mt-3" id="adminSelectedFileName" style="display: none;">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <small class="text-primary">
                                            <i class="bi bi-image me-1"></i>
                                            <span id="adminFileNameText"></span>
                                        </small>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="adminClearPhotoBtn" onclick="clearAdminProfilePhoto()">
                                            <i class="bi bi-x-circle me-1"></i>Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-primary" onclick="updateProfilePicture()">
                            <i class="bi bi-check-circle me-2"></i>Update Photo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('changeProfilePictureModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body and show it
    document.body.insertAdjacentHTML('beforeend', pictureModalHtml);
    const modal = new bootstrap.Modal(document.getElementById('changeProfilePictureModal'));
    modal.show();
    
    // Initialize file upload functionality
    initializeAdminProfileUpload();
    
    // Clean up modal when hidden
    document.getElementById('changeProfilePictureModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

function initializeAdminProfileUpload() {
    const fileInput = document.getElementById('adminProfilePicture');
    const uploadArea = document.getElementById('adminProfileUploadArea');
    const chooseFileBtn = document.getElementById('adminChooseFileBtn');
    const previewContainer = document.getElementById('adminPreviewContainer');
    const previewImage = document.getElementById('adminPreviewImage');

    // Click handlers
    uploadArea.addEventListener('click', () => fileInput.click());
    chooseFileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        fileInput.click();
    });

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleAdminProfileFile(file);
        }
    });

    // Drag and drop handlers
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleAdminProfileFile(files[0]);
        }
    });
}

function handleAdminProfileFile(file) {
    console.log('handleAdminProfileFile called with file:', file.name);
    
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

    // Get the elements
    const previewContainer = document.getElementById('adminPreviewContainer');
    const previewImage = document.getElementById('adminPreviewImage');
    const uploadArea = document.getElementById('adminProfileUploadArea');
    const fileNameDiv = document.getElementById('adminSelectedFileName');
    const fileNameText = document.getElementById('adminFileNameText');
    
    console.log('Admin preview elements found:', {
        previewContainer: !!previewContainer,
        previewImage: !!previewImage,
        uploadArea: !!uploadArea,
        fileNameDiv: !!fileNameDiv,
        fileNameText: !!fileNameText
    });

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        console.log('Admin file reader loaded, setting preview');
        previewImage.src = e.target.result;
        previewContainer.style.display = 'none';
        previewImage.classList.remove('d-none');
        uploadArea.style.border = '3px solid #6c5ce7';
        uploadArea.style.background = 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)';
        
        // Show file name
        fileNameDiv.style.display = 'block';
        fileNameText.textContent = file.name;
    };
    reader.readAsDataURL(file);
}

function clearAdminProfilePhoto() {
    console.log('clearAdminProfilePhoto called');
    
    // Get the elements
    const previewContainer = document.getElementById('adminPreviewContainer');
    const previewImage = document.getElementById('adminPreviewImage');
    const uploadArea = document.getElementById('adminProfileUploadArea');
    const fileNameDiv = document.getElementById('adminSelectedFileName');
    const fileInput = document.getElementById('adminProfilePicture');
    
    // Reset the preview
    previewImage.classList.add('d-none');
    previewContainer.style.display = 'block';
    uploadArea.style.border = '2px dashed #dee2e6';
    uploadArea.style.background = '#f8f9fa';
    
    // Hide file name
    fileNameDiv.style.display = 'none';
    
    // Clear the file input
    fileInput.value = '';
    
    console.log('Admin profile photo preview cleared');
}

function updateProfilePicture() {
    const form = document.getElementById('changeProfilePictureForm');
    const formData = new FormData(form);
    
    // Check if file is selected
    if (!formData.has('profile_picture') || formData.get('profile_picture').size === 0) {
        alert('❌ Please select a profile picture');
        return;
    }
    
    // Make AJAX request
    fetch('{{ route("admin.update-profile-picture") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            bootstrap.Modal.getInstance(document.getElementById('changeProfilePictureModal')).hide();
            
            // Reload profile to show new picture
            loadMyProfile();
            
            // Refresh navigation profile picture immediately
            setTimeout(() => {
                refreshNavigationProfile();
            }, 300);
            
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to update profile picture. Please try again.');
    });
}

function updateActiveMenu(element) {
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.classList.remove('active');
    });
    element.classList.add('active');
}

// Handle hash navigation for My Profile
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded fired, current hash:', window.location.hash);
    
    // Check if URL has #myProfile hash
    if (window.location.hash === '#myProfile') {
        console.log('Found #myProfile hash, calling showMyProfile');
        // Show My Profile section
        showMyProfile();
        
        // Update active menu item
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Find and activate the My Profile menu item
        const profileMenuItem = Array.from(document.querySelectorAll('.list-group-item')).find(item => 
            item.textContent.includes('My Profile')
        );
        if (profileMenuItem) {
            profileMenuItem.classList.add('active');
            console.log('My Profile menu item activated');
        }
    }
    
    // Listen for hash changes
    window.addEventListener('hashchange', function() {
        console.log('Hash changed to:', window.location.hash);
        if (window.location.hash === '#myProfile') {
            console.log('Hash change detected, calling showMyProfile');
            showMyProfile();
        }
    });
    
    // Add event listener for edit profile button
    const editProfileBtn = document.getElementById('editProfileBtn');
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function(e) {
            console.log('Edit Profile button clicked!');
            const userId = this.getAttribute('onclick').match(/\d+/)[0];
            console.log('Extracted userId:', userId);
            editMyProfile(parseInt(userId));
        });
    }
});

function viewUserDetails(userId) {
    // Make AJAX request to get full user details
    fetch('/admin/users/' + userId + '/details', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showUserDetailsModal(data.user);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to load user details. Please try again.');
    });
}

function showUserDetailsModal(user) {
    // Create modal HTML
    const modalHtml = `
        <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-person-badge me-2"></i>User Details - TMCS-${String(user.id).padStart(4, '0')}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Profile Picture Section -->
                            <div class="col-md-4 text-center">
                                <div class="profile-section">
                                    ${user.profile_picture ? 
                                        `<img src="/uploads/profiles/${user.profile_picture}" class="img-fluid rounded-circle mb-3" style="max-width: 150px; height: 150px; object-fit: cover;" alt="Profile Picture">` :
                                        `<div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; margin: 0 auto;">
                                            <i class="bi bi-person fs-1 text-muted"></i>
                                        </div>`
                                    }
                                    <h6 class="text-primary">TMCS-${String(user.id).padStart(4, '0')}</h6>
                                    <p class="text-muted small">${user.name}</p>
                                    <span class="badge bg-${user.role === 'admin' ? 'danger' : user.role === 'leader' ? 'warning' : 'primary'} badge-sm">
                                        ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                                    </span>
                                    <span class="badge bg-${user.membership_status === 'Active' ? 'success' : 'secondary'} badge-sm ms-1">
                                        ${user.membership_status}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- User Details Section -->
                            <div class="col-md-8">
                                <div class="details-section">
                                    <!-- Personal Information -->
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-person-fill me-2"></i>Personal Information
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <strong>User ID:</strong><br>
                                                <span class="text-muted">TMCS-${String(user.id).padStart(4, '0')}</span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Full Name:</strong><br>
                                                <span class="text-muted">${user.name || 'Not set'}</span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Gender:</strong><br>
                                                <span class="text-muted">${user.gender || 'Not set'}</span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Registration Number:</strong><br>
                                                <span class="text-muted">${user.registration_number || 'Not set'}</span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Year of Study:</strong><br>
                                                <span class="text-muted">${user.year_of_study || 'Not set'}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Contact Information -->
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-telephone-fill me-2"></i>Contact Information
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <strong>Email Address:</strong><br>
                                                <span class="text-muted">${user.email || 'Not set'}</span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Phone Number:</strong><br>
                                                <span class="text-muted">${user.phone_number || 'Not set'}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Additional Information -->
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-geo-alt-fill me-2"></i>Additional Information
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <strong>Home Diocese:</strong><br>
                                                <span class="text-muted">${user.home_diocese || 'Not set'}</span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Member Since:</strong><br>
                                                <span class="text-muted">${user.created_at ? new Date(user.created_at).toLocaleDateString() : 'Not set'}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Account Information -->
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="bi bi-shield-lock me-2"></i>Account Information
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <strong>User ID:</strong><br>
                                                <span class="text-muted">TMCS-${String(user.id).padStart(4, '0')}</span>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Account Status:</strong><br>
                                                <span class="badge bg-${user.membership_status === 'Active' ? 'success' : 'secondary'} badge-sm">
                                                    ${user.membership_status}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="editUserDetails(${user.id})">
                                            <i class="bi bi-pencil me-2"></i>Edit User
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm ms-2" onclick="openTopUpForm(${user.id}, '${user.name}')">
                                            <i class="bi bi-credit-card me-2"></i>Top Up
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle me-2"></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('userDetailsModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body and show it
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
    modal.show();
    
    // Clean up modal when hidden
    document.getElementById('userDetailsModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

function openTopUpForm(userId, userName) {
    // Close the details modal first
    const detailsModal = bootstrap.Modal.getInstance(document.getElementById('userDetailsModal'));
    if (detailsModal) {
        detailsModal.hide();
    }
    
    // Create top up modal
    const topUpModalHtml = `
        <div class="modal fade" id="topUpModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-credit-card me-2"></i>Top Up - ${userName}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="topUpForm">
                            <input type="hidden" name="user_id" value="${userId}">
                            
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (TZS)</label>
                                <div class="input-group">
                                    <span class="input-group-text">TZS</span>
                                    <input type="number" class="form-control" id="amount" name="amount" min="100" step="100" required placeholder="Enter amount">
                                </div>
                                <small class="text-muted">Minimum amount: TZS 100</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Select payment method</option>
                                    <option value="mobile">Mobile Money</option>
                                    <option value="bank">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter payment description (optional)"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="transaction_id" class="form-label">Transaction ID</label>
                                <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter transaction ID">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-success" onclick="processTopUp()">
                            <i class="bi bi-check-circle me-2"></i>Process Top Up
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing top up modal if any
    const existingTopUpModal = document.getElementById('topUpModal');
    if (existingTopUpModal) {
        existingTopUpModal.remove();
    }
    
    // Add top up modal to body and show it
    document.body.insertAdjacentHTML('beforeend', topUpModalHtml);
    const topUpModal = new bootstrap.Modal(document.getElementById('topUpModal'));
    topUpModal.show();
    
    // Clean up modal when hidden
    document.getElementById('topUpModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

function processTopUp() {
    const form = document.getElementById('topUpForm');
    const formData = new FormData(form);
    
    // Validate form
    const amount = formData.get('amount');
    const paymentMethod = formData.get('payment_method');
    
    if (!amount || amount < 100) {
        alert('❌ Please enter a valid amount (minimum TZS 100)');
        return;
    }
    
    if (!paymentMethod) {
        alert('❌ Please select a payment method');
        return;
    }
    
    // Convert to JSON for AJAX
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    
    // Make AJAX request
    fetch('/admin/payments/top-up', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            bootstrap.Modal.getInstance(document.getElementById('topUpModal')).hide();
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to process top up. Please try again.');
    });
}

function editUserDetails(userId) {
    // Make AJAX request to get user details for editing
    fetch('/admin/users/' + userId + '/details', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showEditUserModal(data.user);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to load user details for editing. Please try again.');
    });
}

function showEditUserModal(user) {
    // Create edit modal HTML
    const editModalHtml = `
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-square me-2"></i>Edit User - ${user.name}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            <input type="hidden" name="user_id" value="${user.id}">
                            
                            <!-- Personal Information Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-person-fill me-2"></i>Personal Information
                                    </h6>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="edit_name" 
                                           value="${user.name || ''}" required>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_registration_number" class="form-label">Registration Number</label>
                                    <input type="text" name="registration_number" class="form-control" id="edit_registration_number" 
                                           value="${user.registration_number || ''}" placeholder="e.g., TMCS/2024/001">
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_gender" class="form-label">Gender</label>
                                    <select name="gender" class="form-select" id="edit_gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" ${user.gender === 'Male' ? 'selected' : ''}>Male</option>
                                        <option value="Female" ${user.gender === 'Female' ? 'selected' : ''}>Female</option>
                                        <option value="Other" ${user.gender === 'Other' ? 'selected' : ''}>Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_year_of_study" class="form-label">Year of Study</label>
                                    <select name="year_of_study" class="form-select" id="edit_year_of_study">
                                        <option value="">Select Year</option>
                                        <option value="Year 1" ${user.year_of_study === 'Year 1' ? 'selected' : ''}>Year 1</option>
                                        <option value="Year 2" ${user.year_of_study === 'Year 2' ? 'selected' : ''}>Year 2</option>
                                        <option value="Year 3" ${user.year_of_study === 'Year 3' ? 'selected' : ''}>Year 3</option>
                                        <option value="Year 4" ${user.year_of_study === 'Year 4' ? 'selected' : ''}>Year 4</option>
                                        <option value="Year 5" ${user.year_of_study === 'Year 5' ? 'selected' : ''}>Year 5</option>
                                        <option value="Graduate" ${user.year_of_study === 'Graduate' ? 'selected' : ''}>Graduate</option>
                                        <option value="Staff" ${user.year_of_study === 'Staff' ? 'selected' : ''}>Staff</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Contact Information Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-telephone-fill me-2"></i>Contact Information
                                    </h6>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_email" class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="edit_email" 
                                           value="${user.email || ''}" required>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_phone_number" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="tel" name="phone_number" class="form-control" id="edit_phone_number" 
                                               value="${user.phone_number || ''}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Information Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-geo-alt-fill me-2"></i>Additional Information
                                    </h6>
                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <label for="edit_home_diocese" class="form-label">Home Diocese</label>
                                    <input type="text" name="home_diocese" class="form-control" id="edit_home_diocese" 
                                           value="${user.home_diocese || ''}" required>
                                </div>
                            </div>
                            
                            <!-- Account Information Section -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-shield-lock me-2"></i>Account Information
                                    </h6>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_role" class="form-label">Role</label>
                                    <select name="role" class="form-select" id="edit_role" required>
                                        <option value="">Select Role</option>
                                        <option value="member" ${user.role === 'member' ? 'selected' : ''}>Member</option>
                                        <option value="leader" ${user.role === 'leader' ? 'selected' : ''}>Leader</option>
                                        <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                                    </select>
                                    <small class="text-muted">Select the appropriate role for this user</small>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="edit_membership_status" class="form-label">Membership Status</label>
                                    <select name="membership_status" class="form-select" id="edit_membership_status">
                                        <option value="Active" ${user.membership_status === 'Active' ? 'selected' : ''}>Active</option>
                                        <option value="Inactive" ${user.membership_status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                    </select>
                                    <small class="text-muted">Inactive users cannot login to the system</small>
                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit_password_change">
                                        <label class="form-check-label" for="edit_password_change">
                                            Change Password
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-2" id="password_fields" style="display: none;">
                                    <label for="edit_password" class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control" id="edit_password" 
                                           placeholder="Enter new password">
                                </div>
                                
                                <div class="col-md-6 mb-2" id="password_confirm_fields" style="display: none;">
                                    <label for="edit_password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="edit_password_confirmation" 
                                           placeholder="Confirm new password">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-warning" onclick="updateUser()">
                            <i class="bi bi-check-circle me-2"></i>Update User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('editUserModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body and show it
    document.body.insertAdjacentHTML('beforeend', editModalHtml);
    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
    
    // Add password change toggle functionality
    document.getElementById('edit_password_change').addEventListener('change', function() {
        const passwordFields = document.getElementById('password_fields');
        const passwordConfirmFields = document.getElementById('password_confirm_fields');
        
        if (this.checked) {
            passwordFields.style.display = 'block';
            passwordConfirmFields.style.display = 'block';
            document.getElementById('edit_password').required = true;
            document.getElementById('edit_password_confirmation').required = true;
        } else {
            passwordFields.style.display = 'none';
            passwordConfirmFields.style.display = 'none';
            document.getElementById('edit_password').required = false;
            document.getElementById('edit_password_confirmation').required = false;
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_password_confirmation').value = '';
        }
    });
    
    // Clean up modal when hidden
    document.getElementById('editUserModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

function updateUser() {
    const form = document.getElementById('editUserForm');
    const formData = new FormData(form);
    
    // Validate form
    const name = formData.get('name');
    const email = formData.get('email');
    const phone = formData.get('phone_number');
    const role = formData.get('role');
    
    if (!name || !email || !phone || !role) {
        alert('❌ Please fill in all required fields');
        return;
    }
    
    // Check password confirmation if password change is enabled
    const passwordChange = document.getElementById('edit_password_change').checked;
    if (passwordChange) {
        const password = formData.get('password');
        const passwordConfirm = formData.get('password_confirmation');
        
        if (!password || !passwordConfirm) {
            alert('❌ Please enter both password fields');
            return;
        }
        
        if (password !== passwordConfirm) {
            alert('❌ Passwords do not match');
            return;
        }
        
        if (password.length < 6) {
            alert('❌ Password must be at least 6 characters');
            return;
        }
    }
    
    // Convert to JSON for AJAX
    const jsonData = {};
    formData.forEach((value, key) => {
        if (key !== 'password' || passwordChange) {
            jsonData[key] = value;
        }
    });
    
    // Make AJAX request
    fetch('/admin/users/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
            // Reload page to show updated data
            location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to update user. Please try again.');
    });
}

function deleteUserConfirm(userId, userName) {
    if(confirm('Are you sure you want to delete user "' + userName + '"? This action cannot be undone and will permanently remove all user data.')) {
        // Make AJAX request to delete user
        fetch('/admin/users/delete', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                // Remove the row from table immediately
                removeUserRow(userId);
                // Refresh the dashboard after 1 second to update all data
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Failed to delete user. Please try again.');
        });
    }
}

// Function to update UI when user is deleted
function removeUserRow(userId) {
    // Find and remove the user row from table using database ID
    const rows = document.querySelectorAll('#manageUsersTable tbody tr');
    rows.forEach(row => {
        const idCell = row.querySelector('td:first-child');
        if (idCell && idCell.textContent.trim() == userId.toString()) {
            row.remove();
            return true; // Stop searching once found
        }
    });
    
    // Update statistics after deletion
    updateStatistics();
}

function updateUserRole(userId, newRole) {
    if(confirm('Change role for user ID ' + userId + ' to ' + newRole + '?')) {
        // Make AJAX request to update role
        fetch('/admin/users/update-role', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_id: userId,
                role: newRole
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload(); // Reload to see updated role
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Failed to update user role. Please try again.');
        });
    }
}

function updateUserStatus(userId, newStatus) {
    if(confirm('Change status for User ID ' + userId + ' to ' + newStatus + '?')) {
        alert('Status updated for User ID: ' + userId + ' to: ' + newStatus);
        // TODO: Implement AJAX to update status in database
    }
}

// Approval Functions
function approveUser(userId, userName) {
    if(confirm('Approve user "' + userName + '"? Their status will change from Pending to Active.')) {
        // Make AJAX request to approve user
        fetch('/admin/users/approve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                // Update the UI without reload
                updateUserStatusInUI(userId, 'Active');
                // Refresh the dashboard after 1 second to update all data
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Failed to approve user. Please try again.');
        });
    }
}

function rejectUser(userId, userName) {
    if(confirm('Reject user "' + userName + '"? Their status will change from Pending to Inactive and they cannot login.')) {
        // Make AJAX request to reject user
        fetch('/admin/users/reject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                // Update the UI without reload
                updateUserStatusInUI(userId, 'Inactive');
                // Refresh the dashboard after 1 second to update all data
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Failed to reject user. Please try again.');
        });
    }
}

// Bulk Selection Functions
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const bulkRejectBtn = document.getElementById('bulkRejectBtn');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const clearSelectionBtn = document.getElementById('clearSelectionBtn');

    // Select/Deselect all functionality
    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsBar();
    });

    // Individual checkbox change
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionsBar);
    });

    // Update bulk actions bar
    function updateBulkActionsBar() {
        const selectedUsers = document.querySelectorAll('.user-checkbox:checked');
        const count = selectedUsers.length;
        
        selectedCount.textContent = count;
        
        if (count > 0) {
            bulkActionsBar.classList.remove('d-none');
            // Update select all checkbox state
            selectAllCheckbox.checked = count === userCheckboxes.length;
            selectAllCheckbox.indeterminate = count > 0 && count < userCheckboxes.length;
        } else {
            bulkActionsBar.classList.add('d-none');
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
    }

    // Clear selection
    clearSelectionBtn.addEventListener('click', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        selectAllCheckbox.checked = false;
        updateBulkActionsBar();
    });

    // Bulk approve
    bulkApproveBtn.addEventListener('click', function() {
        const selectedUsers = getSelectedUserIds();
        if (selectedUsers.length === 0) return;
        
        if (confirm(`Approve ${selectedUsers.length} selected users?`)) {
            bulkAction('/admin/users/bulk-approve', selectedUsers, 'approved');
        }
    });

    // Bulk reject
    bulkRejectBtn.addEventListener('click', function() {
        const selectedUsers = getSelectedUserIds();
        if (selectedUsers.length === 0) return;
        
        if (confirm(`Reject ${selectedUsers.length} selected users?`)) {
            bulkAction('/admin/users/bulk-reject', selectedUsers, 'rejected');
        }
    });

    // Bulk delete
    bulkDeleteBtn.addEventListener('click', function() {
        const selectedUsers = getSelectedUserIds();
        if (selectedUsers.length === 0) return;
        
        if (confirm(`Delete ${selectedUsers.length} selected users? This action cannot be undone!`)) {
            bulkAction('/admin/users/bulk-delete', selectedUsers, 'deleted');
        }
    });

    // Get selected user IDs
    function getSelectedUserIds() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked');
        return Array.from(checkboxes).map(cb => parseInt(cb.value));
    }

    // Bulk action function
    function bulkAction(url, userIds, action) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_ids: userIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`✅ ${data.message}`);
                // Clear selection and refresh
                clearSelection();
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`❌ Failed to ${action} users. Please try again.`);
        });
    }

    function clearSelection() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        selectAllCheckbox.checked = false;
        updateBulkActionsBar();
    }
});

// Function to update UI without reload
function updateUserStatusInUI(userId, newStatus) {
    // Find the specific row for this user only
    const rows = document.querySelectorAll('#manageUsersTable tbody tr');
    rows.forEach(row => {
        const idCell = row.querySelector('td:first-child');
        if (idCell && idCell.textContent.trim() == userId) {
            const statusCell = row.querySelector('td:nth-child(7)'); // Status column
            
            if (newStatus === 'Active' || newStatus === 'Inactive') {
                // Replace the approval buttons with status badge for this specific user only
                statusCell.innerHTML = `
                    <span class="badge bg-${newStatus === 'Active' ? 'success' : 'secondary'} badge-sm">
                        ${newStatus}
                    </span>
                `;
            }
        }
    });
    
    // Update statistics by counting current visible rows
    updateStatistics();
}

// Function to update statistics
function updateStatistics() {
    const rows = document.querySelectorAll('#manageUsersTable tbody tr');
    let activeCount = 0;
    let pendingCount = 0;
    let inactiveCount = 0;
    
    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(7)'); // Status column
        const statusText = statusCell.textContent.trim();
        
        if (statusText === 'Active') activeCount++;
        else if (statusText === 'Pending') pendingCount++;
        else if (statusText === 'Inactive') inactiveCount++;
    });
    
    // Update the statistics cards
    const activeCard = document.querySelector('.card.bg-success h4');
    const pendingCard = document.querySelector('.card.bg-warning h4');
    const inactiveCard = document.querySelector('.card.bg-danger h4');
    
    if (activeCard) activeCard.textContent = activeCount;
    if (pendingCard) pendingCard.textContent = pendingCount;
    if (inactiveCard) inactiveCard.textContent = inactiveCount;
}

function viewLeaderDetails(leaderId) {
    // Fetch leader details via AJAX
    fetch(`/admin/users/${leaderId}/details`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show leader details in a modal
            showLeaderDetailsModal(data.user);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to load leader details. Please try again.');
    });
}

function showLeaderDetailsModal(user) {
    // Create modal HTML
    const modalHtml = `
        <div class="modal fade" id="leaderDetailsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-person-badge-fill me-2"></i>Leader Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Personal Information</h6>
                                <p><strong>Name:</strong> ${user.name}</p>
                                <p><strong>Email:</strong> ${user.email}</p>
                                <p><strong>Phone:</strong> ${user.phone_number || 'Not set'}</p>
                                <p><strong>Gender:</strong> ${user.gender || 'Not set'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Account Information</h6>
                                <p><strong>User ID:</strong> TMCS-${user.id.toString().padStart(4, '0')}</p>
                                <p><strong>Role:</strong> <span class="badge bg-warning">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</span></p>
                                <p><strong>Status:</strong> <span class="badge bg-${user.membership_status === 'Active' ? 'success' : 'warning'}">${user.membership_status}</span></p>
                                <p><strong>Joined:</strong> ${new Date(user.created_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                        ${user.registration_number ? `<p><strong>Registration Number:</strong> ${user.registration_number}</p>` : ''}
                        ${user.home_diocese ? `<p><strong>Home Diocese:</strong> ${user.home_diocese}</p>` : ''}
                        ${user.year_of_study ? `<p><strong>Year of Study:</strong> ${user.year_of_study}</p>` : ''}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-warning" onclick="editLeaderDetails(${user.id})" data-bs-dismiss="modal">
                            <i class="bi bi-pencil me-2"></i>Edit Leader
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('leaderDetailsModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page and show it
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('leaderDetailsModal'));
    modal.show();
}

function editLeaderDetails(leaderId) {
    // Fetch leader details via AJAX
    fetch(`/admin/users/${leaderId}/details`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show edit form in a modal
            showEditLeaderModal(data.user);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to load leader details. Please try again.');
    });
}

function showEditLeaderModal(user) {
    // Create edit modal HTML
    const modalHtml = `
        <div class="modal fade" id="editLeaderModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-fill me-2"></i>Edit Leader
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editLeaderForm">
                            <input type="hidden" name="user_id" value="${user.id}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="${user.name}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="${user.email}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" value="${user.phone_number || ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male" ${user.gender === 'Male' ? 'selected' : ''}>Male</option>
                                            <option value="Female" ${user.gender === 'Female' ? 'selected' : ''}>Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Registration Number</label>
                                        <input type="text" class="form-control" name="registration_number" value="${user.registration_number || ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Home Diocese</label>
                                        <input type="text" class="form-control" name="home_diocese" value="${user.home_diocese || ''}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Year of Study</label>
                                        <select class="form-select" name="year_of_study">
                                            <option value="">Select Year</option>
                                            <option value="Year 1" ${user.year_of_study === 'Year 1' ? 'selected' : ''}>Year 1</option>
                                            <option value="Year 2" ${user.year_of_study === 'Year 2' ? 'selected' : ''}>Year 2</option>
                                            <option value="Year 3" ${user.year_of_study === 'Year 3' ? 'selected' : ''}>Year 3</option>
                                            <option value="Year 4" ${user.year_of_study === 'Year 4' ? 'selected' : ''}>Year 4</option>
                                            <option value="Year 5" ${user.year_of_study === 'Year 5' ? 'selected' : ''}>Year 5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Membership Status</label>
                                        <select class="form-select" name="membership_status">
                                            <option value="Active" ${user.membership_status === 'Active' ? 'selected' : ''}>Active</option>
                                            <option value="Inactive" ${user.membership_status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" onclick="saveLeaderChanges()">
                            <i class="bi bi-check-circle me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('editLeaderModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page and show it
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modal = new bootstrap.Modal(document.getElementById('editLeaderModal'));
    modal.show();
}

function saveLeaderChanges() {
    const form = document.getElementById('editLeaderForm');
    const formData = new FormData(form);
    
    // Convert FormData to JSON
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    
    fetch('/admin/users/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editLeaderModal'));
            modal.hide();
            // Reload page to show updated data
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Failed to update leader. Please try again.');
    });
}

function demoteLeader(leaderId, leaderName) {
    if(confirm('Demote "' + leaderName + '" from Leader to Member? They will lose leadership privileges.')) {
        fetch('/admin/users/update-role', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_id: leaderId,
                role: 'member'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                // Reload page to show updated data
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Failed to demote leader. Please try again.');
        });
    }
}

function deleteLeader(leaderId, leaderName) {
    if(confirm('⚠️ WARNING: Delete "' + leaderName + '" permanently?\n\nThis action cannot be undone. All user data will be permanently deleted.')) {
        if(confirm('🚨 FINAL WARNING: Are you absolutely sure you want to delete "' + leaderName + '"? This cannot be undone!')) {
            fetch('/admin/users/delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    user_id: leaderId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    // Reload page to show updated data
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Failed to delete leader. Please try again.');
            });
        }
    }
}

document.getElementById('searchManageUsers')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#manageUsersTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Handle Add Member Form Submission
function handleAddMemberSubmit(event) {
    event.preventDefault();
    
    const form = document.getElementById('addMemberForm');
    const formData = new FormData(form);
    
    // Show loading
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating...';
    submitBtn.disabled = true;
    
    fetch('/admin/members/store', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('New member created successfully!');
            
            // Reset form
            form.reset();
            
            // Clear profile picture preview
            const previewContainer = document.getElementById('previewContainer');
            if (previewContainer) {
                previewContainer.innerHTML = `
                    <i class="bi bi-cloud-upload fs-3 text-muted mb-2"></i>
                    <h6 class="small">Drag & Drop photo</h6>
                    <p class="text-muted mb-2 small">or</p>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="chooseFileBtn">
                        <i class="bi bi-folder2-open me-1"></i>Choose File
                    </button>
                `;
            }
            
            // Show success message
            const successAlert = document.createElement('div');
            successAlert.className = 'alert alert-success alert-dismissible fade show';
            successAlert.innerHTML = `
                <strong>Success!</strong> ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            form.parentElement.insertBefore(successAlert, form);
            
            // Remove alert after 5 seconds
            setTimeout(() => {
                successAlert.remove();
            }, 5000);
            
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating member. Please try again.');
    })
    .finally(() => {
        // Restore button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Combined filter function - apply both role and status filters together
function applyFilters() {
    const roleFilter = document.getElementById('roleManageFilter').value;
    const statusFilter = document.getElementById('statusManageFilter').value;
    const rows = document.querySelectorAll('#manageUsersTable tbody tr');
    
    rows.forEach(row => {
        let showRow = true;
        
        // Check role filter
        if (roleFilter !== '') {
            const roleCell = row.querySelector('td:nth-child(7)'); // Role column (updated for checkbox column)
            const roleText = roleCell.textContent.trim().toLowerCase();
            if (roleText !== roleFilter.toLowerCase()) {
                showRow = false;
            }
        }
        
        // Check status filter
        if (statusFilter !== '') {
            const statusCell = row.querySelector('td:nth-child(8)'); // Status column (updated for checkbox column)
            const statusText = statusCell.textContent.trim().toLowerCase();
            if (statusText !== statusFilter.toLowerCase()) {
                showRow = false;
            }
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

// Add event listeners for combined filtering
document.getElementById('roleManageFilter')?.addEventListener('change', applyFilters);
document.getElementById('statusManageFilter')?.addEventListener('change', applyFilters);

document.getElementById('searchLeaders')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#manageLeadersTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Member Reports Interface
function showMemberReportsInterface() {
    const reportsContent = document.getElementById('reportsContent');
    reportsContent.style.display = 'block';
    reportsContent.innerHTML = `
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-people me-2"></i>Member Reports Generator
                </h5>
            </div>
            <div class="card-body">
                <form id="memberReportsForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Report Type</label>
                                <select class="form-select" id="memberReportType" name="memberReportType" required>
                                    <option value="">Select Report Type</option>
                                    <option value="all_members">All Members</option>
                                    <option value="by_role">By Role</option>
                                    <option value="by_registration_date">Member Report by Date Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Export Format</label>
                                <select class="form-select" id="memberReportFormat" name="memberReportFormat" required>
                                    <option value="">Select Format</option>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="roleFilterRow" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Role Filter</label>
                                <select class="form-select" id="memberRoleFilter" name="memberRoleFilter">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="leader">Leader</option>
                                    <option value="member">Member</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="memberDateRangeRow" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" class="form-control" id="memberFromDate" name="memberFromDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" class="form-control" id="memberToDate" name="memberToDate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Include Payment History</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includePaymentHistory" name="includePaymentHistory">
                                    <label class="form-check-label" for="includePaymentHistory">
                                        Yes, include payment history
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Include Contact Details</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeContactDetails" name="includeContactDetails">
                                    <label class="form-check-label" for="includeContactDetails">
                                        Yes, include phone numbers
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="bi bi-file-earmark-text me-2"></i>Generate Member Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    // Add event listeners
    document.getElementById('memberReportsForm').addEventListener('submit', generateMemberReport);
    document.getElementById('memberReportType').addEventListener('change', toggleMemberReportFilters);
}

// General Reports Interface
function showGeneralReportsInterface() {
    const reportsContent = document.getElementById('reportsContent');
    reportsContent.style.display = 'block';
    reportsContent.innerHTML = `
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>General Reports Generator
                </h5>
            </div>
            <div class="card-body">
                <form id="generalReportsForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Report Type</label>
                                <select class="form-select" id="generalReportType" name="generalReportType" required>
                                    <option value="">Select Report Type</option>
                                    <option value="all_payments_list">All Payments List</option>
                                    <option value="payments_by_date_range">Payments by Date Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Export Format</label>
                                <select class="form-select" id="generalReportFormat" name="generalReportFormat" required>
                                    <option value="">Select Format</option>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="generalDateRangeRow" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" class="form-control" id="generalFromDate" name="generalFromDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" class="form-control" id="generalToDate" name="generalToDate">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="paymentTypeFilterRow" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Payment Type</label>
                                <select class="form-select" id="generalPaymentTypeFilter" name="generalPaymentTypeFilter">
                                    <option value="">All Payment Types</option>
                                    <option value="membership">Membership</option>
                                    <option value="certificate">Certificate</option>
                                    <option value="zaka">Zaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="specificDateContainer" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Specific Date</label>
                                <input type="date" class="form-control" id="generalSpecificDate" name="generalSpecificDate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Include Summary</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeSummary" name="includeSummary" checked>
                                    <label class="form-check-label" for="includeSummary">
                                        Include summary statistics
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Include Charts</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeCharts" name="includeCharts">
                                    <label class="form-check-label" for="includeCharts">
                                        Include charts (PDF only)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-bar-chart me-2"></i>Generate General Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    // Add event listeners
    document.getElementById('generalReportsForm').addEventListener('submit', generateGeneralReport);
    document.getElementById('generalReportType').addEventListener('change', toggleGeneralReportFilters);
}

// Supporting Functions
function loadMembersForReport() {
    // Load members for dropdown
    fetch('/admin/users/all')
        .then(response => response.json())
        .then(data => {
            const memberSelect = document.getElementById('memberSelect');
            if (memberSelect && data.users) {
                memberSelect.innerHTML = '<option value="">All Members</option>';
                data.users.forEach(user => {
                    memberSelect.innerHTML += `<option value="${user.id}">${user.name}</option>`;
                });
            }
        })
        .catch(error => {
            console.error('Error loading members:', error);
        });
}

function toggleMemberReportFilters() {
    const reportType = document.getElementById('memberReportType').value;
    const roleFilterRow = document.getElementById('roleFilterRow');
    const memberDateRangeRow = document.getElementById('memberDateRangeRow');
    
    // Show role filter for "By Role" report
    roleFilterRow.style.display = reportType === 'by_role' ? 'block' : 'none';
    // Show date range for "Member Report by Date Range"
    memberDateRangeRow.style.display = reportType === 'by_registration_date' ? 'block' : 'none';
}

function toggleGeneralReportFilters() {
    const reportType = document.getElementById('generalReportType').value;
    const generalDateRangeRow = document.getElementById('generalDateRangeRow');
    const paymentTypeFilterRow = document.getElementById('paymentTypeFilterRow');
    const specificDateContainer = document.getElementById('specificDateContainer');
    
    // Show date range for date range reports
    generalDateRangeRow.style.display = 
        (reportType === 'payments_by_date_range') 
        ? 'block' : 'none';
    
    // Show payment type filter for all payment reports
    paymentTypeFilterRow.style.display = 
        (reportType === 'all_payments_list' || reportType === 'payments_by_date_range') 
        ? 'block' : 'none';
    
    // Show specific date only for all payments list
    specificDateContainer.style.display = 
        (reportType === 'all_payments_list') 
        ? 'block' : 'none';
}

function generateMemberReport(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Validate form
    const reportType = formData.get('memberReportType');
    const format = formData.get('memberReportFormat');
    
    if (!reportType) {
        alert('Please select a report type');
        return;
    }
    
    if (!format) {
        alert('Please select an export format');
        return;
    }
    
    console.log('Generating member report:', { reportType, format });
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating...';
    submitBtn.disabled = true;
    
    // Convert FormData to JSON
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    
    fetch('/admin/reports/member', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Member report response:', response);
        
        // Check if response is PDF (direct download)
        if (response.headers.get('content-type')?.includes('application/pdf')) {
            // Handle direct PDF download
            return response.blob().then(blob => {
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'member_report.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
                
                // Show success message
                alert('Member report generated successfully!');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        } else {
            // Handle JSON response (error or other formats)
            return response.json().then(data => {
                if (data.success) {
                    alert('Member report generated successfully!');
                    if (data.download_url) {
                        // Create a temporary link to force download
                        const link = document.createElement('a');
                        link.href = data.download_url;
                        link.download = data.filename || 'report.pdf';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                } else {
                    alert('Error: ' + data.message);
                }
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating report. Please try again.');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function generateGeneralReport(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Validate form
    const reportType = formData.get('generalReportType');
    const format = formData.get('generalReportFormat');
    
    if (!reportType) {
        alert('Please select a report type');
        return;
    }
    
    if (!format) {
        alert('Please select an export format');
        return;
    }
    
    console.log('Generating general report:', { reportType, format });
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Generating...';
    submitBtn.disabled = true;
    
    // Convert FormData to JSON
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    
    fetch('/admin/reports/general', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('General report response:', response);
        
        // Check if response is PDF (direct download)
        if (response.headers.get('content-type')?.includes('application/pdf')) {
            // Handle direct PDF download
            return response.blob().then(blob => {
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'general_report.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
                
                // Show success message
                alert('General report generated successfully!');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        } else if (response.headers.get('content-type')?.includes('text/csv') || 
                  response.headers.get('content-type')?.includes('application/vnd.ms-excel')) {
            // Handle CSV/Excel download
            return response.blob().then(blob => {
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'general_report.' + (format === 'csv' ? 'csv' : 'xlsx');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
                
                // Show success message
                alert('General report generated successfully!');
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        } else {
            // Handle JSON response (error or other formats)
            return response.json().then(data => {
                if (data.success) {
                    alert('General report generated successfully!');
                    if (data.download_url) {
                        // Create a temporary link to force download
                        const link = document.createElement('a');
                        link.href = data.download_url;
                        link.download = data.filename || 'report.pdf';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                } else {
                    alert('Error: ' + data.message);
                }
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating report. Please try again.');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Function to view announcement image in modal
function viewAnnouncementImage(imageSrc, announcementTitle) {
    // Create modal HTML
    const modalHtml = `
        <div class="modal fade" id="imageViewerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white">${announcementTitle} - Image Viewer</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0 text-center">
                        <img src="${imageSrc}" alt="${announcementTitle}" class="img-fluid" style="max-height: 80vh; width: auto;">
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="${imageSrc}" download="announcement_${announcementTitle}.jpg" class="btn btn-primary">
                            <i class="bi bi-download me-1"></i>Download Image
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if present
    const existingModal = document.getElementById('imageViewerModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
    modal.show();
    
    // Remove modal from DOM when hidden
    document.getElementById('imageViewerModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

// Admin Personal Payment Functions
function handleAdminPaymentTypeChange() {
    const paymentType = document.getElementById('adminPaymentType').value;
    const installmentOptions = document.getElementById('adminInstallmentOptions');
    const installmentInfo = document.getElementById('adminInstallmentInfo');
    const amountInput = document.getElementById('adminPaymentAmount');
    
    if (paymentType === 'membership') {
        installmentOptions.style.display = 'block';
        installmentInfo.style.display = 'block';
        document.getElementById('adminInstallmentInfoText').innerHTML = 
            '<strong>Membership Fee:</strong> TZS 2,000 per year. Full payment required.';
        amountInput.value = '2000';
        amountInput.readOnly = true;
    } else if (paymentType === 'certificate') {
        installmentOptions.style.display = 'block';
        installmentInfo.style.display = 'block';
        document.getElementById('adminInstallmentInfoText').innerHTML = 
            '<strong>Certificate Fee:</strong> TZS 4,000 for students in second year and above preparing for graduation. Full payment required.';
        amountInput.value = '4000';
        amountInput.readOnly = true;
    } else if (paymentType === 'zaka') {
        installmentOptions.style.display = 'block';
        installmentInfo.style.display = 'block';
        document.getElementById('adminInstallmentInfoText').innerHTML = 
            '<strong>Zaka:</strong> TZS 2,000 voluntary contribution. Full payment required.';
        amountInput.value = '2000';
        amountInput.readOnly = true;
    } else {
        installmentOptions.style.display = 'none';
        installmentInfo.style.display = 'none';
        amountInput.readOnly = false;
        amountInput.value = '';
    }
    
    // Auto-fill description based on payment type
    autoFillAdminDescription();
}

function handleAdminYearChange() {
    const yearSelect = document.getElementById('adminPaymentYear').value;
    const customYearDiv = document.getElementById('adminCustomYearDiv');
    
    if (yearSelect === 'custom_year') {
        customYearDiv.style.display = 'block';
        document.getElementById('adminCustomYear').required = true;
    } else {
        customYearDiv.style.display = 'none';
        document.getElementById('adminCustomYear').required = false;
        document.getElementById('adminCustomYear').value = '';
    }
}

function handleAdminInstallmentChange() {
    const installmentType = document.getElementById('adminInstallmentType').value;
    const paymentType = document.getElementById('adminPaymentType').value;
    const amountInput = document.getElementById('adminPaymentAmount');
    
    if (installmentType === 'full') {
        // Keep the full amount
        if (paymentType === 'membership') amountInput.value = '2000';
        else if (paymentType === 'certificate') amountInput.value = '4000';
        else if (paymentType === 'zaka') amountInput.value = '2000';
    }
    
    autoFillAdminDescription();
}

function autoFillAdminDescription() {
    const paymentType = document.getElementById('adminPaymentType').value;
    const installmentType = document.getElementById('adminInstallmentType').value;
    const descriptionField = document.getElementById('adminPaymentDescription');
    const yearValue = document.getElementById('adminPaymentYear').value;
    
    let description = '';
    
    if (paymentType === 'membership') {
        description = 'Membership fee payment';
    } else if (paymentType === 'certificate') {
        description = 'Certificate fee payment';
    } else if (paymentType === 'zaka') {
        description = 'Zaka contribution';
    } else if (paymentType === 'donation') {
        description = 'Donation contribution';
    } else if (paymentType === 'event') {
        description = 'Event fee payment';
    } else if (paymentType === 'other') {
        description = 'Other payment';
    }
    
    if (yearValue && yearValue !== 'custom_year') {
        description += ` for ${yearValue}`;
    }
    
    if (installmentType === 'full') {
        description += ' (Full payment)';
    }
    
    descriptionField.value = description;
}

function showAdminPaymentDetails() {
    const paymentMethod = document.getElementById('adminPaymentMethod').value;
    const detailsSection = document.getElementById('adminPaymentDetailsSection');
    const instructionsDiv = document.getElementById('adminPaymentInstructions');
    
    if (paymentMethod) {
        detailsSection.style.display = 'block';
        
        let instructions = '';
        
        // Handle dynamic account options (mobile_1, bank_2, etc.)
        if (paymentMethod.startsWith('mobile_')) {
            const selectedOption = document.querySelector('#adminPaymentMethod option[value="' + paymentMethod + '"]');
            const accountText = selectedOption ? selectedOption.textContent : '';
            instructions = `
                <strong>Mobile Money Payment Instructions:</strong><br>
                <strong>Account:</strong> ${accountText}<br>
                Please make the payment to the mobile money number above.<br>
                <em>Upload the transaction confirmation message as proof of payment.</em>
            `;
        } else if (paymentMethod.startsWith('bank_')) {
            const selectedOption = document.querySelector('#adminPaymentMethod option[value="' + paymentMethod + '"]');
            const accountText = selectedOption ? selectedOption.textContent : '';
            instructions = `
                <strong>Bank Transfer Instructions:</strong><br>
                <strong>Account:</strong> ${accountText}<br>
                Please transfer the amount to the bank account above.<br>
                <em>Upload the transfer receipt as proof of payment.</em>
            `;
        } else {
            // Fallback for any other payment methods
            switch(paymentMethod) {
                case 'cash':
                    instructions = `
                        <strong>Cash Payment Instructions:</strong><br>
                        Please deposit cash at the church office and obtain a receipt.<br>
                        <strong>Office Hours:</strong> Monday - Friday, 9:00 AM - 4:00 PM
                    `;
                    break;
                case 'bank_transfer':
                    instructions = `
                        <strong>Bank Transfer Instructions:</strong><br>
                        Please transfer to the church bank account.<br>
                        <em>Upload the transfer receipt as proof of payment.</em>
                    `;
                    break;
                case 'mobile_money':
                    instructions = `
                        <strong>Mobile Money Instructions:</strong><br>
                        Please send money to the church mobile money number.<br>
                        <em>Upload the transaction confirmation as proof.</em>
                    `;
                    break;
                case 'cheque':
                    instructions = `
                        <strong>Cheque Payment Instructions:</strong><br>
                        Please make cheques payable to the church.<br>
                        Submit at the church office during office hours.
                    `;
                    break;
                case 'online':
                    instructions = `
                        <strong>Online Payment Instructions:</strong><br>
                        Click the button below to proceed with secure online payment.<br>
                        <button class="btn btn-primary mt-2" onclick="processOnlinePayment()">
                            <i class="bi bi-credit-card me-2"></i>Pay Online
                        </button>
                    `;
                    break;
                default:
                    instructions = 'Please select a payment method to see instructions.';
            }
        }
        
        instructionsDiv.innerHTML = instructions;
    } else {
        detailsSection.style.display = 'none';
    }
}

function previewAdminAttachment(input) {
    const preview = document.getElementById('adminAttachmentPreview');
    const previewContent = document.getElementById('adminAttachmentPreviewContent');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Check file size (2MB limit)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const fileType = file.type;
            
            if (fileType.startsWith('image/')) {
                previewContent.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 300px;" alt="Payment proof">`;
            } else if (fileType === 'application/pdf') {
                previewContent.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-file-earmark-pdf" style="font-size: 4rem; color: #dc3545;"></i>
                        <p class="mt-2 mb-0">${file.name}</p>
                        <small class="text-muted">PDF Document</small>
                    </div>
                `;
            } else {
                previewContent.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-file-earmark" style="font-size: 4rem; color: #6c757d;"></i>
                        <p class="mt-2 mb-0">${file.name}</p>
                        <small class="text-muted">File</small>
                    </div>
                `;
            }
            
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    }
}

function removeAdminAttachment() {
    document.getElementById('adminPaymentAttachment').value = '';
    document.getElementById('adminAttachmentPreview').style.display = 'none';
    document.getElementById('adminAttachmentPreviewContent').innerHTML = '';
}

function resetAdminPaymentForm() {
    const form = document.getElementById('adminPaymentForm');
    if (form) {
        form.reset();
        
        // Hide conditional sections
        document.getElementById('adminCustomYearDiv').style.display = 'none';
        document.getElementById('adminInstallmentOptions').style.display = 'none';
        document.getElementById('adminInstallmentInfo').style.display = 'none';
        document.getElementById('adminPaymentDetailsSection').style.display = 'none';
        document.getElementById('adminAttachmentPreview').style.display = 'none';
        
        // Clear preview
        document.getElementById('adminAttachmentPreviewContent').innerHTML = '';
        
        // Remove readonly from amount field
        document.getElementById('adminPaymentAmount').readOnly = false;
    }
}

// Handle admin payment form submission
document.addEventListener('DOMContentLoaded', function() {
    const adminPaymentForm = document.getElementById('adminPaymentForm');
    
    if (adminPaymentForm) {
        adminPaymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
            submitBtn.disabled = true;
            
            // Add admin user ID to form data
            formData.append('user_id', '{{ Auth::id() }}');
            
            fetch('/admin/payments/store-personal', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success alert-dismissible fade show';
                    successAlert.innerHTML = `
                        <i class="bi bi-check-circle me-2"></i>${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    
                    // Insert at the top of the personal-payment tab
                    const personalPaymentTab = document.getElementById('personal-payment');
                    personalPaymentTab.insertBefore(successAlert, personalPaymentTab.firstChild);
                    
                    // Reset form
                    resetAdminPaymentForm();
                    
                    // Auto-hide success message after 5 seconds
                    setTimeout(() => {
                        successAlert.remove();
                    }, 5000);
                    
                } else {
                    // Show error message
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                    errorAlert.innerHTML = `
                        <i class="bi bi-exclamation-triangle me-2"></i>${data.message || 'Payment submission failed'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    
                    const personalPaymentTab = document.getElementById('personal-payment');
                    personalPaymentTab.insertBefore(errorAlert, personalPaymentTab.firstChild);
                    
                    // Auto-hide error message after 5 seconds
                    setTimeout(() => {
                        errorAlert.remove();
                    }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                errorAlert.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>An error occurred while processing your payment
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const personalPaymentTab = document.getElementById('personal-payment');
                personalPaymentTab.insertBefore(errorAlert, personalPaymentTab.firstChild);
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
@endsection
