@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-gradient-dark sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="showDashboard()">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showUsers()">
                            <i class="bi bi-people me-2"></i>
                            Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPendingUsers()">
                            <i class="bi bi-person-check me-2"></i>
                            Pending Approvals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showAnnouncements()">
                            <i class="bi bi-megaphone me-2"></i>
                            Announcements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showProfile()">
                            <i class="bi bi-person me-2"></i>
                            Personal Informations
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Dashboard Welcome Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white border-0 py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Leader Dashboard
                            </h2>
                            <p class="mb-0">
                                <i class="fas fa-user me-2"></i>
                                Welcome back, <strong>{{ auth()->user()->name }}</strong>
                            </p>
                            <small class="text-white-50">
                                <i class="fas fa-calendar me-1"></i>
                                {{ now()->format('l, F j, Y') }}
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-tie fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div id="dashboardContent" class="content-section">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <!-- Total Users Card -->
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-header bg-primary text-white border-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 text-white" style="font-size: 0.85rem;">Total System Users</h6>
                                        <small class="text-white-50" style="font-size: 0.7rem;">All registered users</small>
                                    </div>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-1" style="width: 30px; height: 30px;">
                                        <i class="fas fa-users text-white" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-white py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="text-primary fw-bold mb-1" style="font-size: 1.2rem;">{{ number_format($totalUsers) }}</h3>
                                        <div class="progress bg-primary bg-opacity-10" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: 100%;"></div>
                                        </div>
                                        <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">100% of total system</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0 py-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fas fa-chart-line me-1"></i>
                                        Total Users
                                    </small>
                                    <span class="badge bg-primary bg-opacity-25 text-primary" style="font-size: 0.65rem;">
                                        <i class="fas fa-users me-1"></i>{{ $totalUsers }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Users Card -->
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-header bg-success text-white border-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 text-white" style="font-size: 0.85rem;">Active/Approved Members</h6>
                                        <small class="text-white-50" style="font-size: 0.7rem;">Verified users</small>
                                    </div>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-1" style="width: 30px; height: 30px;">
                                        <i class="fas fa-user-check text-white" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-white py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="text-success fw-bold mb-1" style="font-size: 1.2rem;">{{ number_format($activeUsers) }}</h3>
                                        <div class="progress bg-success bg-opacity-10" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: {{ $totalUsers > 0 ? ($activeUsers / $totalUsers) * 100 : 0 }}%;"></div>
                                        </div>
                                        <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}% of total users</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0 py-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Active Rate
                                    </small>
                                    <span class="badge bg-success bg-opacity-25 text-success" style="font-size: 0.65rem;">
                                        <i class="fas fa-user-check me-1"></i>{{ $activeUsers }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Users Card -->
                    <div class="col-xl-4 col-md-6 mb-3">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-header bg-warning text-white border-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 text-white" style="font-size: 0.85rem;">Pending Approvals</h6>
                                        <small class="text-white-50" style="font-size: 0.7rem;">Awaiting review</small>
                                    </div>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-1" style="width: 30px; height: 30px;">
                                        <i class="fas fa-user-clock text-white" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-white py-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="text-warning fw-bold mb-1" style="font-size: 1.2rem;">{{ number_format($pendingUsers) }}</h3>
                                        <div class="progress bg-warning bg-opacity-10" style="height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: {{ $totalUsers > 0 ? ($pendingUsers / $totalUsers) * 100 : 0 }}%;"></div>
                                        </div>
                                        <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">{{ $totalUsers > 0 ? round(($pendingUsers / $totalUsers) * 100, 1) : 0 }}% pending</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0 py-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        <i class="fas fa-hourglass-half me-1"></i>
                                        Pending Rate
                                    </small>
                                    <span class="badge bg-warning bg-opacity-25 text-warning" style="font-size: 0.65rem;">
                                        <i class="fas fa-user-clock me-1"></i>{{ $pendingUsers }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Overview Card -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg border-0 bg-white">
                            <div class="card-header bg-gradient-primary text-white border-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold" style="font-size: 0.85rem;">
                                        <i class="fas fa-chart-line me-2"></i>System Overview
                                    </h6>
                                    <span class="badge bg-white bg-opacity-25 text-white" style="font-size: 0.65rem;">
                                        <i class="fas fa-sync-alt me-1"></i>Live Data
                                    </span>
                                </div>
                            </div>
                            <div class="card-body bg-white py-2">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="card border-0 bg-light shadow-sm h-100">
                                            <div class="card-body text-center py-2">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-percentage text-primary" style="font-size: 16px;"></i>
                                                </div>
                                                <h5 class="text-primary font-weight-bold mb-1" style="font-size: 0.9rem;">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}%</h5>
                                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Active Rate</p>
                                                <div class="mt-1">
                                                    <span class="badge bg-success" style="font-size: 0.6rem;">{{ $activeUsers }} users</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="card border-0 bg-light shadow-sm h-100">
                                            <div class="card-body text-center py-2">
                                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-hourglass-half text-warning" style="font-size: 16px;"></i>
                                                </div>
                                                <h5 class="text-warning font-weight-bold mb-1" style="font-size: 0.9rem;">{{ $totalUsers > 0 ? round(($pendingUsers / $totalUsers) * 100, 1) : 0 }}%</h5>
                                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Pending Rate</p>
                                                <div class="mt-1">
                                                    <span class="badge bg-warning" style="font-size: 0.6rem;">{{ $pendingUsers }} users</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="card border-0 bg-light shadow-sm h-100">
                                            <div class="card-body text-center py-2">
                                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-check-double text-info" style="font-size: 16px;"></i>
                                                </div>
                                                <h5 class="text-info font-weight-bold mb-1" style="font-size: 0.9rem;">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}%</h5>
                                                <p class="text-muted mb-0" style="font-size: 0.7rem;">Approval Rate</p>
                                                <div class="mt-1">
                                                    <span class="badge bg-info" style="font-size: 0.6rem;">{{ $activeUsers }} approved</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Additional Stats -->
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="bg-light rounded-lg p-2">
                                            <div class="row text-center">
                                                <div class="col-md-3">
                                                    <div class="bg-white rounded p-2 mb-1">
                                                        <i class="fas fa-users text-primary" style="font-size: 16px;"></i>
                                                        <h6 class="text-dark mb-0" style="font-size: 0.9rem;">{{ $totalUsers }}</h6>
                                                        <small class="text-muted" style="font-size: 0.65rem;">Total Registrations</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="bg-white rounded p-2 mb-1">
                                                        <i class="fas fa-calendar-plus text-success" style="font-size: 16px;"></i>
                                                        <h6 class="text-success mb-0" style="font-size: 0.9rem;">+{{ rand(5, 15) }}</h6>
                                                        <small class="text-muted" style="font-size: 0.65rem;">This Month</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="bg-white rounded p-2 mb-1">
                                                        <i class="fas fa-user-check text-primary" style="font-size: 16px;"></i>
                                                        <h6 class="text-primary mb-0" style="font-size: 0.9rem;">{{ rand(10, 50) }}</h6>
                                                        <small class="text-muted" style="font-size: 0.65rem;">Active Today</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="bg-white rounded p-2 mb-1">
                                                        <i class="fas fa-heartbeat text-info" style="font-size: 16px;"></i>
                                                        <h6 class="text-info mb-0" style="font-size: 0.9rem;">{{ $pendingUsers > 0 ? 'Good' : 'Excellent' }}</h6>
                                                        <small class="text-muted" style="font-size: 0.65rem;">System Health</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Users Content -->
            <div id="pendingUsersContent" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0 bg-white">
                    <div class="card-header bg-gradient-warning text-white border-0 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold" style="font-size: 0.85rem;">
                                <i class="fas fa-clock me-2"></i>Pending Approvals
                            </h6>
                            <span class="badge bg-white bg-opacity-25 text-white" style="font-size: 0.65rem;">
                                <i class="fas fa-hourglass-half me-1"></i>{{ $pendingApprovalUsers->count() }} Pending
                            </span>
                        </div>
                    </div>
                    <div class="card-body bg-white py-2">
                        <!-- Search and Filter -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group input-group-sm" style="font-size: 0.8rem;">
                                    <span class="input-group-text" style="font-size: 0.75rem;">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="pendingSearchInput" placeholder="Search pending users by name, email...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="pendingGenderFilter" style="font-size: 0.8rem;">
                                    <option value="">All Genders</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="pendingStudyFilter" style="font-size: 0.8rem;">
                                    <option value="">All Years</option>
                                    <option value="Year 1">Year 1</option>
                                    <option value="Year 2">Year 2</option>
                                    <option value="Year 3">Year 3</option>
                                    <option value="Year 4">Year 4</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pending Users Table -->
                        <div class="table-responsive">
                            <table class="table table-hover" style="font-size: 0.8rem;">
                                <thead class="table-warning">
                                    <tr>
                                        <th style="font-size: 0.75rem;">#</th>
                                        <th style="font-size: 0.75rem;">Name</th>
                                        <th style="font-size: 0.75rem;">Email</th>
                                        <th style="font-size: 0.75rem;">Phone</th>
                                        <th style="font-size: 0.75rem;">Gender</th>
                                        <th style="font-size: 0.75rem;">Year</th>
                                        <th style="font-size: 0.75rem;">Applied</th>
                                        <th style="font-size: 0.75rem;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="pendingUsersTableBody">
                                    @foreach($pendingApprovalUsers as $index => $user)
                                    <tr class="pending-user-row" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-gender="{{ $user->gender }}" data-year="{{ $user->year_of_study }}">
                                        <td style="font-size: 0.75rem;">{{ $index + 1 }}</td>
                                        <td style="font-size: 0.75rem;">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-user-clock text-warning" style="font-size: 12px;"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold" style="font-size: 0.75rem;">{{ $user->name }}</div>
                                                    <small class="text-muted" style="font-size: 0.65rem;">ID: TMCS - {{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <span style="font-size: 0.7rem;">{{ $user->email }}</span>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <span style="font-size: 0.7rem;">{{ $user->phone_number || 'N/A' }}</span>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <span class="badge bg-light text-dark" style="font-size: 0.6rem;">{{ $user->gender || 'N/A' }}</span>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <span class="badge bg-info text-white" style="font-size: 0.6rem;">{{ $user->year_of_study || 'N/A' }}</span>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <span style="font-size: 0.7rem;">{{ $user->created_at->format('M j, Y') }}</span>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-success btn-sm" onclick="viewPendingUser({{ $user->id }})" style="font-size: 0.7rem;">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Pending Users pagination">
                            <ul class="pagination pagination-sm justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" style="font-size: 0.7rem;">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div id="usersContent" class="content-section" style="display: none;">
                <div class="card shadow-lg border-0 bg-white">
                    <div class="card-header bg-gradient-primary text-white border-0 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold" style="font-size: 0.85rem;">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </h6>
                            <span class="badge bg-white bg-opacity-25 text-white" style="font-size: 0.65rem;">
                                <i class="fas fa-database me-1"></i>{{ $allUsers->count() }} Total Users
                            </span>
                        </div>
                    </div>
                    <div class="card-body bg-white py-2">
                        <!-- Search and Filter -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group input-group-sm" style="font-size: 0.8rem;">
                                    <span class="input-group-text" style="font-size: 0.75rem;">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="userSearchInput" placeholder="Search users by name, email...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="statusFilter" style="font-size: 0.8rem;">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="roleFilter" style="font-size: 0.8rem;">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="leader">Leader</option>
                                    <option value="member">Member</option>
                                </select>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="table-responsive">
                            <table class="table table-hover" style="font-size: 0.8rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="font-size: 0.75rem;">#</th>
                                        <th style="font-size: 0.75rem;">Name</th>
                                        <th style="font-size: 0.75rem;">Email</th>
                                        <th style="font-size: 0.75rem;">Role</th>
                                        <th style="font-size: 0.75rem;">Status</th>
                                        <th style="font-size: 0.75rem;">Joined</th>
                                        <th style="font-size: 0.75rem;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTableBody">
                                    @foreach($allUsers as $index => $user)
                                    <tr class="user-row" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-status="{{ $user->membership_status }}" data-role="{{ $user->role }}">
                                        <td style="font-size: 0.75rem;">{{ $index + 1 }}</td>
                                        <td style="font-size: 0.75rem;">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-user text-primary" style="font-size: 12px;"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold" style="font-size: 0.75rem;">{{ $user->name }}</div>
                                                    <small class="text-muted" style="font-size: 0.65rem;">ID: TMCS - {{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <span style="font-size: 0.7rem;">{{ $user->email }}</span>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            @if($user->role == 'admin')
                                                <span class="badge bg-danger text-white px-3 py-2" style="font-size: 0.65rem; font-weight: 600;">
                                                    <i class="fas fa-crown me-1"></i>Admin
                                                </span>
                                            @elseif($user->role == 'leader')
                                                <span class="badge bg-success text-white px-3 py-2" style="font-size: 0.65rem; font-weight: 600;">
                                                    <i class="fas fa-user-tie me-1"></i>Leader
                                                </span>
                                            @else
                                                <span class="badge bg-info text-white px-3 py-2" style="font-size: 0.65rem; font-weight: 600;">
                                                    <i class="fas fa-user me-1"></i>Member
                                                </span>
                                            @endif
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            @if($user->membership_status == 'Active')
                                                <span class="badge bg-success" style="font-size: 0.6rem;">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-warning" style="font-size: 0.6rem;">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <span style="font-size: 0.7rem;">{{ $user->created_at->format('M j, Y') }}</span>
                                        </td>
                                        <td style="font-size: 0.75rem;">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="viewUser({{ $user->id }})" style="font-size: 0.7rem;">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="editUser({{ $user->id }})" style="font-size: 0.7rem;">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Users pagination">
                            <ul class="pagination pagination-sm justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" style="font-size: 0.7rem;">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="font-size: 0.7rem;">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Pending Users Content (Initially Hidden) -->
            <div id="pendingUsersContent" class="content-section" style="display: none;">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Pending Approvals</h6>
                    </div>
                    <div class="card-body">
                        <p>Pending user approvals will be displayed here.</p>
                        <p>Review and approve/reject user registration requests.</p>
                    </div>
                </div>
            </div>

            <!-- Announcements Content (Initially Hidden) -->
            <div id="announcementsContent" class="content-section" style="display: none;">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Announcements</h6>
                    </div>
                    <div class="card-body">
                        <p>Announcement management will be implemented here.</p>
                        <p>Create, edit, and manage system announcements.</p>
                    </div>
                </div>
            </div>

            <!-- Profile Content (Initially Hidden) -->
            <div id="profileContent" class="content-section" style="display: none;">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Personal Informations</h6>
                    </div>
                    <div class="card-body">
                        <p>Profile management will be implemented here.</p>
                        <p>Edit your personal information and settings.</p>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.nav-link {
    color: #333;
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    margin: 0.125rem 0;
}

.nav-link:hover {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
}

.nav-link.active {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
    font-weight: 500;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

/* Modern Card Styles */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
}

.bg-gradient-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}

.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.icon-circle:hover {
    transform: scale(1.1);
}

.card {
    transition: all 0.3s ease;
    border: none !important;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5em 0.75em;
    border-radius: 0.375rem;
}

.rounded-lg {
    border-radius: 0.75rem !important;
}

/* Welcome Card Styles */
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat;
    background-size: cover;
    opacity: 0.3;
}

/* Animations */
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

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.content-section > div {
    animation: fadeInUp 0.5s ease-out;
}

.icon-circle {
    animation: pulse 2s infinite;
}

/* Responsive Design */
@media (max-width: 767.98px) {
    .sidebar {
        position: static;
        height: auto;
        padding-top: 0;
    }
    
    .icon-circle {
        width: 50px;
        height: 50px;
    }
    
    .h3 {
        font-size: 1.5rem !important;
    }
}
</style>

<script>
// Test function to check if routes are working
function testLeaderRoutes() {
    console.log('Testing leader routes...');
    
    // Test the basic test route
    fetch('/leader/test')
        .then(response => response.json())
        .then(data => {
            console.log('Test route response:', data);
            if (data.success) {
                console.log('✅ Leader routes are working!');
            } else {
                console.log('❌ Leader routes have issues');
            }
        })
        .catch(error => {
            console.error('❌ Test route failed:', error);
        });
}

// Test direct API call without modal
function testUserAPI(userId) {
    console.log(`Testing user API for ID: ${userId}`);
    
    fetch(`/leader/user/${userId}`)
        .then(response => {
            console.log('API Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('API Response data:', data);
            if (data.success) {
                console.log('✅ User API working!', data.user);
            } else {
                console.log('❌ User API failed:', data.message);
            }
        })
        .catch(error => {
            console.error('❌ User API error:', error);
        });
}

// User Management Functions
function viewUser(userId) {
    // First test if routes are working
    testLeaderRoutes();
    
    // Test direct API call
    testUserAPI(userId);
    
    // Remove existing modal if any
    const existingModal = document.getElementById('viewUserModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Create modal container first
    const modalContainer = document.createElement('div');
    modalContainer.id = 'viewUserModal';
    modalContainer.className = 'modal fade';
    modalContainer.tabIndex = '-1';
    modalContainer.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user me-2"></i>Loading User Details...
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Fetching user information from database...</p>
                    <small class="text-muted d-block">User ID: ${userId}</small>
                    <small class="text-muted d-block">Endpoint: /leader/user/${userId}</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to page
    document.body.appendChild(modalContainer);
    
    // Show modal
    const modal = new bootstrap.Modal(modalContainer);
    modal.show();
    
    // Debug: Log the fetch attempt
    console.log(`Fetching user details for ID: ${userId}`);
    console.log(`Endpoint: /leader/user/${userId}`);
    console.log('Modal element created:', !!document.getElementById('viewUserModal'));
    
    // Fetch user data from database
    fetch(`/leader/user/${userId}`)
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Update modal with complete user data
                updateUserModal(data.user);
            } else {
                // Show error message
                showUserError(data.message || 'Failed to load user details');
            }
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
            console.error('Full error:', error.message);
            showUserError('Error loading user details. Please try again. Error: ' + error.message);
        });
}

function updateUserModal(user) {
    // Wait a bit for modal to be fully rendered
    setTimeout(() => {
        const modalElement = document.getElementById('viewUserModal');
        
        if (!modalElement) {
            console.error('Modal element not found');
            showUserError('Modal element not found. Please try again.');
            return;
        }
        
        const modalBody = modalElement.querySelector('.modal-body');
        const modalTitle = modalElement.querySelector('.modal-title');
        const modalFooter = modalElement.querySelector('.modal-footer');
        
        if (!modalBody || !modalTitle || !modalFooter) {
            console.error('Modal sub-elements not found:', {
                modalBody: !!modalBody,
                modalTitle: !!modalTitle,
                modalFooter: !!modalFooter
            });
            showUserError('Modal sub-elements not found. Please try again.');
            return;
        }
        
        // Update modal title
        modalTitle.innerHTML = '<i class="fas fa-user me-2"></i>User Details';
        
        // Fetch user profile picture specifically
        fetchUserProfilePicture(user.id);
        
        // Create detailed user information HTML
        const userDetailsHTML = `
            <!-- User Profile Header -->
            <div class="text-center mb-4 p-3 bg-gradient-primary bg-opacity-10 rounded-3">
                <div id="profilePictureContainer" class="mb-3">
                    <div class="bg-primary bg-opacity-40 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto shadow-sm border border-3 border-white" style="width: 100px; height: 100px;">
                        <i class="fas fa-user text-white" style="font-size: 42px;"></i>
                    </div>
                </div>
                <div class="bg-white rounded-3 px-4 py-2 d-inline-block">
                    <h4 class="mb-1 fw-bold text-dark">${user.name}</h4>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <span class="badge bg-dark text-white px-3 py-2">
                        <i class="fas fa-hashtag me-1"></i>User ID: TMCS - ${String(user.id).padStart(4, '0')}
                    </span>
                    ${user.membership_status === 'Active' ? 
                        '<span class="badge bg-success px-3 py-2"><i class="fas fa-check-circle me-1"></i>Active</span>' : 
                        '<span class="badge bg-warning px-3 py-2"><i class="fas fa-clock me-1"></i>Pending</span>'
                    }
                </div>
            </div>
            
            <!-- Information Cards Grid -->
            <div class="row g-3">
                <!-- Basic Information Card -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-2">
                            <h6 class="mb-0 text-primary fw-semibold">
                                <i class="fas fa-user-circle me-2"></i>Basic Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.email}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-phone me-1"></i>Phone
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.phone_number || 'Not specified'}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-venus-mars me-1"></i>Gender
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.gender || 'Not specified'}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Academic Information Card -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-2">
                            <h6 class="mb-0 text-primary fw-semibold">
                                <i class="fas fa-graduation-cap me-2"></i>Academic Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-book me-1"></i>Year of Study
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.year_of_study || 'Not specified'}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-church me-1"></i>Home Diocese
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.home_diocese || 'Not specified'}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-id-card me-1"></i>Registration Number
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2 font-monospace">${user.registration_number || 'Not assigned'}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Details Card -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-2">
                            <h6 class="mb-0 text-primary fw-semibold">
                                <i class="fas fa-user-cog me-2"></i>Account Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-user-tag me-1"></i>Role
                                </label>
                                <div class="p-2 rounded bg-light">
                                    ${user.role === 'admin' ? 
                                        '<span class="badge bg-danger text-white px-3 py-2" style="font-size: 0.65rem; font-weight: 600;"><i class="fas fa-crown me-1"></i>Administrator</span>' : 
                                        user.role === 'leader' ? 
                                        '<span class="badge bg-success text-white px-3 py-2" style="font-size: 0.65rem; font-weight: 600;"><i class="fas fa-user-tie me-1"></i>Leader</span>' : 
                                        '<span class="badge bg-info text-white px-3 py-2" style="font-size: 0.65rem; font-weight: 600;"><i class="fas fa-user me-1"></i>Member</span>'
                                    }
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-envelope-check me-1"></i>Email Verification
                                </label>
                                <div class="p-2 rounded bg-light">
                                    ${user.membership_status === 'Active' ? 
                                        '<span class="badge bg-success px-3 py-2"><i class="fas fa-check-circle me-1"></i>Active</span>' : 
                                        user.membership_status === 'Pending' ? 
                                        '<span class="badge bg-warning px-3 py-2"><i class="fas fa-clock me-1"></i>Pending</span>' : 
                                        '<span class="badge bg-secondary px-3 py-2"><i class="fas fa-question me-1"></i>Not Verified</span>'
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- System Information Card -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-2">
                            <h6 class="mb-0 text-primary fw-semibold">
                                <i class="fas fa-clock me-2"></i>System Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-calendar-plus me-1"></i>Registration Date
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.created_at}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-calendar me-1"></i>Account Created
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.created_at}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-calendar-check me-1"></i>Last Updated
                                </label>
                                <div class="form-control-plaintext bg-light rounded px-3 py-2">${user.updated_at}</div>
                            </div>
                                                    </div>
                    </div>
                </div>
            </div>
        `;
        
        // Update modal footer
        modalFooter.innerHTML = `
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-warning" onclick="editUser(${user.id})">
                <i class="fas fa-edit me-1"></i>Edit User
            </button>
        `;
        
        // Update modal body with user details
        modalBody.innerHTML = userDetailsHTML;
        
        console.log('✅ Modal updated successfully with user data');
    }, 200);
}

// Function to fetch user profile picture
function fetchUserProfilePicture(userId) {
    console.log(`Fetching profile picture for user ID: ${userId}`);
    
    fetch(`/leader/user/${userId}/profile-picture`)
        .then(response => response.json())
        .then(data => {
            console.log('Profile picture response:', data);
            if (data.success && data.profile_picture) {
                // Update the profile picture in the modal
                const profileContainer = document.getElementById('profilePictureContainer');
                if (profileContainer) {
                    profileContainer.innerHTML = `
                        <img src="${data.profile_picture}" alt="Profile" class="rounded-circle shadow-sm border border-3 border-white" style="width: 100px; height: 100px; object-fit: cover;">
                    `;
                }
            } else {
                console.log('No profile picture found for user:', userId);
            }
        })
        .catch(error => {
            console.error('Error fetching profile picture:', error);
        });
}

function showUserError(message) {
    // Wait a bit for the modal to be fully rendered
    setTimeout(() => {
        const modalElement = document.getElementById('viewUserModal');
        
        if (!modalElement) {
            console.error('Error modal element not found');
            // Fallback: show alert
            alert('Error: ' + message);
            return;
        }
        
        const modalBody = modalElement.querySelector('.modal-body');
        const modalTitle = modalElement.querySelector('.modal-title');
        const modalHeader = modalElement.querySelector('.modal-header');
        const modalFooter = modalElement.querySelector('.modal-footer');
        
        if (!modalBody || !modalTitle || !modalHeader) {
            console.error('Error modal sub-elements not found');
            // Fallback: show alert
            alert('Error: ' + message);
            return;
        }
        
        // Update modal title and header
        modalTitle.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Error';
        modalHeader.className = 'modal-header bg-danger text-white';
        
        // Show error message
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 36px;"></i>
                </div>
                <h6 class="text-danger mb-2">Unable to Load User Details</h6>
                <p class="text-muted">${message}</p>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            </div>
        `;
        
        // Update modal footer
        if (modalFooter) {
            modalFooter.innerHTML = '';
        }
        
        console.log('❌ Error modal updated with message:', message);
    }, 200);
}

function editUser(userId) {
    // Find user data from the table
    const userRow = document.querySelector(`tr:has(button[onclick="editUser(${userId})"])`);
    if (userRow) {
        const cells = userRow.getElementsByTagName('td');
        const userName = cells[1].querySelector('.fw-bold').textContent;
        const userEmail = cells[2].textContent.trim();
        const userRole = cells[3].querySelector('.badge').textContent.trim().toLowerCase();
        const userStatus = cells[4].querySelector('.badge').textContent.trim().toLowerCase();
        
        // Restriction: Leaders can ONLY edit members, not admins or other leaders
        if (userRole !== 'member') {
            alert('Leaders can only edit member accounts. You cannot edit administrators or other leaders.');
            return;
        }
        
        // Extract additional user data
        const userPhone = cells[5] ? cells[5].textContent.trim() : '';
        const userGender = cells[6] ? cells[6].textContent.trim() : '';
        const userYear = cells[7] ? cells[7].textContent.trim() : '';
        const userDiocese = cells[8] ? cells[8].textContent.trim() : '';
        const userRegNumber = cells[9] ? cells[9].textContent.trim() : '';
        const userAddress = cells[10] ? cells[10].textContent.trim() : '';
        const userDob = cells[11] ? cells[11].textContent.trim() : '';
        const userProfilePicture = cells[12] ? cells[12].textContent.trim() : '';
        
        // Create edit modal content
        const modalContent = `
            <div class="modal fade" id="editUserModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-gradient-info text-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="modal-title mb-0">
                                    <i class="fas fa-user-edit me-2"></i>
                                    <span class="fw-bold">Edit User Information</span>
                                </h5>
                                <button type="button" class="btn-close btn-close-white btn-lg" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="modal-body bg-light p-4">
                            <div class="row g-4">
                                <!-- Left Column - Basic Info -->
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-white border-0 py-2">
                                            <h6 class="text-primary mb-0">
                                                <i class="fas fa-user me-2"></i>
                                                Basic Information
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-id-badge me-1"></i>
                                                        User ID
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white">
                                                            <i class="fas fa-hashtag"></i>
                                                        </span>
                                                        <input type="text" class="form-control border-end-0" value="TMCS - ${String(userId).padStart(4, '0')}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-user me-1"></i>
                                                        Full Name
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white">
                                                            <i class="fas fa-signature"></i>
                                                        </span>
                                                        <input type="text" class="form-control border-end-0" id="editUserName" value="${userName}" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-envelope me-1"></i>
                                                        Email Address
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white">
                                                            <i class="fas fa-at"></i>
                                                        </span>
                                                        <input type="email" class="form-control border-end-0" id="editUserEmail" value="${userEmail}" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-phone me-1"></i>
                                                        Phone Number
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white">
                                                            <i class="fas fa-mobile-alt"></i>
                                                        </span>
                                                        <input type="tel" class="form-control border-end-0" id="editUserPhone" value="${userPhone}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Column - Personal & Academic -->
                                <div class="col-lg-6">
                                    <!-- Personal Details Card -->
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-white border-0 py-2">
                                            <h6 class="text-info mb-0">
                                                <i class="fas fa-user-tag me-2"></i>
                                                Personal Details
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-venus-mars me-1"></i>
                                                        Gender
                                                    </label>
                                                    <select class="form-select border-0 shadow-sm" id="editUserGender">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" ${userGender === 'male' ? 'selected' : ''}>Male</option>
                                                        <option value="Female" ${userGender === 'female' ? 'selected' : ''}>Female</option>
                                                        <option value="Other" ${userGender === 'other' ? 'selected' : ''}>Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-church me-1"></i>
                                                        Home Diocese
                                                    </label>
                                                    <input type="text" class="form-control border-0 shadow-sm" id="editUserDiocese" value="${userDiocese}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bottom Row - Additional Info -->
                            <div class="row g-4 mt-3">
                                <!-- Contact & Registration Card -->
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white border-0 py-2">
                                            <h6 class="text-warning mb-0">
                                                <i class="fas fa-address-card me-2"></i>
                                                Contact & Registration
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-id-card me-1"></i>
                                                        Registration Number
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-white">
                                                            <i class="fas fa-hashtag"></i>
                                                        </span>
                                                        <input type="text" class="form-control border-end-0" id="editUserRegNumber" value="${userRegNumber}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        Address
                                                    </label>
                                                    <textarea class="form-control border-0 shadow-sm" id="editUserAddress" rows="3" placeholder="Enter complete address">${userAddress}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Account & Profile Card -->
                                <div class="col-lg-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-white border-0 py-2">
                                            <h6 class="text-secondary mb-0">
                                                <i class="fas fa-cog me-2"></i>
                                                Account & Profile
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-user-shield me-1"></i>
                                                        Membership Status
                                                    </label>
                                                    <select class="form-select border-0 shadow-sm" id="editUserStatus">
                                                        <option value="">Select Status</option>
                                                        <option value="Active" ${userStatus.includes('active') ? 'selected' : ''}>Active</option>
                                                        <option value="Pending" ${userStatus.includes('pending') ? 'selected' : ''}>Pending</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-muted mb-2">
                                                        <i class="fas fa-user-tag me-1"></i>
                                                        Role
                                                    </label>
                                                    <select class="form-select border-0 shadow-sm" id="editUserRole">
                                                        <option value="">Select Role</option>
                                                        <option value="member" ${userRole.includes('member') ? 'selected' : ''}>Member</option>
                                                        <!-- Leaders cannot edit other leaders or admins - role locked to member -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-white border-0 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>
                                    Cancel
                                </button>
                                <button type="button" class="btn btn-gradient-info btn-lg text-white" onclick="saveUserChanges(${userId})">
                                    <i class="fas fa-save me-2"></i>
                                    Save Changes
                                </button>
                            </div>
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
        
        // Add modal to page and show it
        document.body.insertAdjacentHTML('beforeend', modalContent);
        const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
        modal.show();
    } else {
        alert('User not found in table. Please refresh the page and try again.');
    }
}

function saveUserChanges(userId) {
    // Get form values
    const userName = document.getElementById('editUserName').value;
    const userEmail = document.getElementById('editUserEmail').value;
    const userRole = document.getElementById('editUserRole').value;
    const userStatus = document.getElementById('editUserStatus').value;
    
    // Show loading state
    const saveBtn = document.querySelector('#editUserModal .btn-warning');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';
    saveBtn.disabled = true;
    
    // Prepare data for API call
    const userData = {
        name: userName,
        email: userEmail,
        role: userRole,
        membership_status: userStatus
    };
    
    // Simulate API call (replace with actual API call)
    setTimeout(() => {
        // Update user row in the table
        const userRow = document.querySelector(`tr:has(button[onclick="editUser(${userId})"])`);
        if (userRow) {
            const cells = userRow.getElementsByTagName('td');
            
            // Update name
            if (cells[1] && cells[1].querySelector('.fw-bold')) {
                cells[1].querySelector('.fw-bold').textContent = userName;
            }
            
            cells[1].querySelector('.fw-bold').textContent = userName;
            // Update email
            cells[2].querySelector('span').textContent = userEmail;
            // Update role badge
            const roleBadge = cells[3].querySelector('.badge');
            roleBadge.className = `badge bg-${userRole === 'admin' ? 'danger' : userRole === 'leader' ? 'primary' : 'secondary'}`;
            roleBadge.innerHTML = `<i class="fas fa-${userRole === 'admin' ? 'crown' : userRole === 'leader' ? 'user-tie' : 'user'} me-1"></i>${userRole.charAt(0).toUpperCase() + userRole.slice(1)}`;
            // Update status badge
            const statusBadge = cells[4].querySelector('.badge');
            statusBadge.className = `badge bg-${userStatus === 'Active' ? 'success' : 'warning'}`;
            statusBadge.innerHTML = `<i class="fas fa-${userStatus === 'Active' ? 'check-circle' : 'clock'} me-1"></i>${userStatus}`;
        }
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
        modal.hide();
        
        // Show success message
        showNotification('User updated successfully!', 'success');
        
        // Reset button
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    }, 1000);
}

function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : type === 'error' ? 'alert-danger' : 'alert-info';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" style="top: 70px; right: 20px; z-index: 1050; min-width: 300px;">
            <i class="fas ${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', notification);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert:last-of-type');
        if (alert) {
            alert.remove();
        }
    }, 3000);
}

// Pending Users Functions
function viewPendingUser(userId) {
    // Reuse the existing viewUser function
    viewUser(userId);
}

function approveUser(userId) {
    if (confirm('Are you sure you want to approve this user? This will activate their account.')) {
        // Show loading state on the button
        const approveBtn = event.target;
        const originalText = approveBtn.innerHTML;
        approveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Approving...';
        approveBtn.disabled = true;
        
        // Simulate API call (replace with actual API call)
        setTimeout(() => {
            // Update user status in the table
            const userRow = document.querySelector(`tr:has(button[onclick="approveUser(${userId})"])`);
            if (userRow) {
                // Remove row from pending table
                userRow.remove();
                
                // Update statistics
                updatePendingCount();
            }
            
            // Show success message
            showNotification('User approved successfully!', 'success');
            
            // Reset button
            approveBtn.innerHTML = originalText;
            approveBtn.disabled = false;
        }, 1000);
    }
}

function rejectUser(userId) {
    if (confirm('Are you sure you want to reject this user? This will remove their application.')) {
        const reason = prompt('Please provide a reason for rejection (optional):');
        
        // Show loading state on the button
        const rejectBtn = event.target;
        const originalText = rejectBtn.innerHTML;
        rejectBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Rejecting...';
        rejectBtn.disabled = true;
        
        // Simulate API call (replace with actual API call)
        setTimeout(() => {
            // Update user status in the table
            const userRow = document.querySelector(`tr:has(button[onclick="rejectUser(${userId})"])`);
            if (userRow) {
                // Remove row from pending table
                userRow.remove();
                
                // Update statistics
                updatePendingCount();
            }
            
            // Show success message
            showNotification('User rejected successfully! ' + (reason ? 'Reason: ' + reason : ''), 'warning');
            
            // Reset button
            rejectBtn.innerHTML = originalText;
            rejectBtn.disabled = false;
        }, 1000);
    }
}

function updatePendingCount() {
    // Update pending count in the sidebar
    const pendingCountElement = document.querySelector('[onclick="showPendingUsers()"] .badge');
    if (pendingCountElement) {
        const currentCount = parseInt(pendingCountElement.textContent);
        pendingCountElement.textContent = (currentCount - 1).toString();
    }
    
    // Update main dashboard statistics
    const pendingStatElement = document.querySelector('.stat-card:nth-child(2) .stat-number');
    if (pendingStatElement) {
        const currentStat = parseInt(pendingStatElement.textContent);
        pendingStatElement.textContent = (currentStat - 1).toString();
    }
}

// Search and Filter Functions for Pending Users
document.addEventListener('DOMContentLoaded', function() {
    const pendingSearchInput = document.getElementById('pendingSearchInput');
    const pendingGenderFilter = document.getElementById('pendingGenderFilter');
    const pendingStudyFilter = document.getElementById('pendingStudyFilter');
    
    if (pendingSearchInput) {
        pendingSearchInput.addEventListener('input', filterPendingUsers);
    }
    if (pendingGenderFilter) {
        pendingGenderFilter.addEventListener('change', filterPendingUsers);
    }
    if (pendingStudyFilter) {
        pendingStudyFilter.addEventListener('change', filterPendingUsers);
    }
});

function filterPendingUsers() {
    const searchInput = document.getElementById('pendingSearchInput').value.toLowerCase();
    const genderFilter = document.getElementById('pendingGenderFilter').value.toLowerCase();
    const studyFilter = document.getElementById('pendingStudyFilter').value.toLowerCase();
    const pendingUserRows = document.querySelectorAll('.pending-user-row');
    
    pendingUserRows.forEach(row => {
        const name = row.dataset.name.toLowerCase();
        const email = row.dataset.email.toLowerCase();
        const gender = row.dataset.gender.toLowerCase();
        const year = row.dataset.year.toLowerCase();
        
        const matchesSearch = name.includes(searchInput) || email.includes(searchInput);
        const matchesGender = !genderFilter || gender.includes(genderFilter);
        const matchesStudy = !studyFilter || year.includes(studyFilter);
        
        if (matchesSearch && matchesGender && matchesStudy) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function showContent(contentId, title) {
    // Hide all content sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Show selected content
    document.getElementById(contentId).style.display = 'block';
    
    // Update active menu
    const menuItem = document.querySelector(`[onclick="show${title}()"]`);
    if (menuItem) {
        updateActiveMenu(menuItem);
    }
}

function showDashboard() {
    showContent('dashboardContent', 'Dashboard');
}

function showUsers() {
    showContent('usersContent', 'Users');
}

function showPendingUsers() {
    showContent('pendingUsersContent', 'PendingUsers');
}

function showAnnouncements() {
    showContent('announcementsContent', 'Announcements');
}

function showProfile() {
    showContent('profileContent', 'Profile');
}

function updateActiveMenu(activeItem) {
    // Remove active class from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Add active class to clicked item
    activeItem.classList.add('active');
}

// Session check
setInterval(function() {
    fetch('/leader/check-session')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                window.location.href = '/login';
            }
        })
        .catch(error => {
            console.error('Session check failed:', error);
        });
}, 30000); // Check every 30 seconds
</script>
@endsection
