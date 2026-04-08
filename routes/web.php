
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AnnouncementController;

// Debug route for checking logs
Route::get('/debug/logs', function() {
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lastLines = array_slice($lines, -50);
        return implode('', $lastLines);
    }
    return 'Log file not found.';
});


Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

Route::get('/test-email', function () {
    Mail::to('digitalhubmrnavigator@gmail.com')->send(new TestMail());
    return "Email Sent!";
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot password routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.forgot');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submit'])->name('password.submit');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOTP'])->name('password.verify-otp');
Route::post('/resend-otp', [ForgotPasswordController::class, 'resendOTP'])->name('password.resend-otp');

// Registration routes
Route::get('/register', [RegisterController::class, 'showForm']);
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard routes (protected by middleware)
Route::middleware(['auth'])->group(function () {
    // General dashboard route (redirects based on role)
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    
    // Admin routes
    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/check-session', [\App\Http\Controllers\Admin\DashboardController::class, 'checkSession'])->name('admin.check-session');
        Route::post('/generate-payment-pdf', [\App\Http\Controllers\Admin\DashboardController::class, 'generatePaymentPDF'])->name('admin.generate-payment-pdf');
    });
    
    // Leader routes
    Route::middleware(['auth'])->prefix('leader')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Leader\DashboardController::class, 'index'])->name('leader.dashboard');
        
        // Profile management routes for leaders
        Route::post('/profile/update', [\App\Http\Controllers\Leader\DashboardController::class, 'updateProfile'])->name('leader.profile.update');
        Route::get('/check-session', [\App\Http\Controllers\Leader\DashboardController::class, 'checkSession'])->name('leader.check-session');
        Route::get('/user/{userId}', [\App\Http\Controllers\Leader\DashboardController::class, 'getUserDetails'])->name('leader.user.details');
        Route::get('/user/{userId}/profile-picture', [\App\Http\Controllers\Leader\DashboardController::class, 'getUserProfilePicture'])->name('leader.user.profile-picture');
        
        // Test route for debugging
        Route::get('/test', function() {
            return response()->json([
                'success' => true,
                'message' => 'Leader test route working!',
                'user' => auth()->user() ? auth()->user()->name : 'Not authenticated'
            ]);
        });
        
        // Payment Accounts routes for leaders
        Route::get('/payment-accounts', [\App\Http\Controllers\Leader\PaymentAccountController::class, 'index'])->name('leader.payment-accounts.index');
        Route::get('/accounts', [\App\Http\Controllers\Leader\DashboardController::class, 'getAccounts'])->name('leader.accounts.index');
        
        // Payment routes for leaders
        Route::post('/payments/store', [\App\Http\Controllers\PaymentController::class, 'store'])->name('leader.payments.store');
        Route::get('/payments/history', [\App\Http\Controllers\PaymentController::class, 'history'])->name('leader.payments.history');
        
        // Announcements routes for leaders
        Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'index'])->name('leader.announcements.index');
        Route::post('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'create'])->name('leader.announcements.create');
        Route::put('/announcements/{id}', [\App\Http\Controllers\AnnouncementController::class, 'update'])->name('leader.announcements.update');
        Route::delete('/announcements/{id}', [\App\Http\Controllers\AnnouncementController::class, 'destroy'])->name('leader.announcements.destroy');
        
        // Reports routes for leaders
        Route::post('/reports/generate-general', [\App\Http\Controllers\Leader\ReportController::class, 'generateGeneralReport'])->name('leader.reports.generate-general');
        Route::post('/reports/export-general', [\App\Http\Controllers\Leader\ReportController::class, 'exportGeneralData'])->name('leader.reports.export-general');
        Route::post('/reports/generate-member', [\App\Http\Controllers\Leader\ReportController::class, 'generateMemberReport'])->name('leader.reports.generate-member');
        Route::post('/reports/export-member', [\App\Http\Controllers\Leader\ReportController::class, 'exportMemberData'])->name('leader.reports.export-member');
        
        // Debug route for checking users
        Route::get('/debug/users', [\App\Http\Controllers\Leader\DebugController::class, 'checkUsers'])->name('leader.debug.users');
        
        // Leader user management routes
        Route::get('/users', [\App\Http\Controllers\Leader\UserController::class, 'index'])->name('leader.users.index');
        Route::get('/users/{id}', [\App\Http\Controllers\Leader\UserController::class, 'show'])->name('leader.users.show');
        Route::put('/users/{id}/status', [\App\Http\Controllers\Leader\UserController::class, 'updateStatus'])->name('leader.users.update.status');
        
        // Test endpoint for debugging
        Route::post('/test-payment', function(\Illuminate\Http\Request $request) {
            return response()->json([
                'success' => true,
                'message' => 'Test endpoint working',
                'data' => $request->all()
            ]);
        });
    });
    
    // Member routes
    Route::middleware(['auth'])->prefix('member')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('member.dashboard');
        Route::get('/check-session', [\App\Http\Controllers\Member\DashboardController::class, 'checkSession'])->name('member.check-session');
        Route::get('/profile', [\App\Http\Controllers\Member\ProfileController::class, 'show'])->name('member.profile');
        Route::put('/profile', [\App\Http\Controllers\Member\ProfileController::class, 'update'])->name('member.profile.update');
        
        // Member announcements (view only)
        Route::get('/announcements', [\App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('member.announcements');
        Route::get('/current-user', [\App\Http\Controllers\Member\ProfileController::class, 'getCurrentUser'])->name('member.current-user');
        Route::get('/settings', function() {
            return view('member.settings');
        })->name('member.settings');
        
        // Payment routes
        Route::post('/payments/store', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/history', [\App\Http\Controllers\PaymentController::class, 'history'])->name('payments.history');
        Route::get('/payment-summary', [\App\Http\Controllers\PaymentController::class, 'paymentSummary'])->name('payments.summary');
        
        // Payment Accounts routes for members
        Route::get('/payment-accounts', [\App\Http\Controllers\Member\PaymentAccountController::class, 'index'])->name('member.payment-accounts.index');
        
        // PDF Reports routes for members
        Route::get('/pdf-reports', [\App\Http\Controllers\Member\DashboardController::class, 'getPdfReports'])->name('member.pdf-reports');
        Route::get('/download-pdf-report/{reportId}', [\App\Http\Controllers\Member\DashboardController::class, 'downloadPdfReport'])->name('member.download-pdf-report');
    });

    // Admin User Management Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        // Add New Member Route
        Route::post('/members/store', [\App\Http\Controllers\Admin\UserManagementController::class, 'storeNewMember'])->name('admin.members.store');
        
        Route::post('/users/update-role', [\App\Http\Controllers\Admin\UserManagementController::class, 'updateRole'])->name('admin.users.update-role');
        Route::post('/users/update-status', [\App\Http\Controllers\Admin\UserManagementController::class, 'updateStatus'])->name('admin.users.update-status');
        Route::post('/users/approve', [\App\Http\Controllers\Admin\UserManagementController::class, 'approveUser'])->name('admin.users.approve');
        Route::post('/users/reject', [\App\Http\Controllers\Admin\UserManagementController::class, 'rejectUser'])->name('admin.users.reject');
        Route::get('/users/{userId}/details', [\App\Http\Controllers\Admin\UserManagementController::class, 'getUserDetails'])->name('admin.users.details');
        Route::post('/users/update', [\App\Http\Controllers\Admin\UserManagementController::class, 'updateUser'])->name('admin.users.update');
        Route::post('/payments/top-up', [\App\Http\Controllers\Admin\UserManagementController::class, 'processTopUp'])->name('admin.payments.top-up');
        Route::get('/payments/all', [\App\Http\Controllers\Admin\PaymentController::class, 'getAllPayments'])->name('admin.payments.all');
        Route::get('/users/all', [\App\Http\Controllers\Admin\UserManagementController::class, 'getAllUsers'])->name('admin.users.all');
        Route::post('/payments/{paymentId}/approve', [\App\Http\Controllers\Admin\PaymentController::class, 'approvePayment'])->name('admin.payments.approve');
        Route::post('/payments/{paymentId}/reject', [\App\Http\Controllers\Admin\PaymentController::class, 'rejectPayment'])->name('admin.payments.reject');
        Route::post('/payments/store-personal', [\App\Http\Controllers\Admin\PaymentController::class, 'storePersonalPayment'])->name('admin.payments.store-personal');
        Route::get('/payments/accounts', [\App\Http\Controllers\Admin\PaymentController::class, 'getPaymentAccounts'])->name('admin.payments.accounts');
        Route::delete('/users/delete', [\App\Http\Controllers\Admin\UserManagementController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Bulk User Management Routes
        Route::post('/users/bulk-approve', [\App\Http\Controllers\Admin\UserManagementController::class, 'bulkApproveUsers'])->name('admin.users.bulk-approve');
        Route::post('/users/bulk-reject', [\App\Http\Controllers\Admin\UserManagementController::class, 'bulkRejectUsers'])->name('admin.users.bulk-reject');
        Route::post('/users/bulk-delete', [\App\Http\Controllers\Admin\UserManagementController::class, 'bulkDeleteUsers'])->name('admin.users.bulk-delete');
        
        // Admin Profile Management
        Route::post('/change-password', [\App\Http\Controllers\Admin\UserManagementController::class, 'changePassword'])->name('admin.change-password');
        Route::get('/current-user', [\App\Http\Controllers\Admin\UserManagementController::class, 'getCurrentUser'])->name('admin.current-user');
        
        // Accounts Management Routes
        Route::get('/accounts', [\App\Http\Controllers\Admin\AccountController::class, 'index'])->name('admin.accounts.index');
        
        // Reports Routes
        Route::post('/reports/payment', [\App\Http\Controllers\Admin\ReportController::class, 'generatePaymentReport'])->name('admin.reports.payment');
        Route::post('/reports/member', [\App\Http\Controllers\Admin\ReportController::class, 'generateMemberReport'])->name('admin.reports.member');
        Route::post('/reports/general', [\App\Http\Controllers\Admin\ReportController::class, 'generateGeneralReport'])->name('admin.reports.general');
        Route::post('/accounts', [\App\Http\Controllers\Admin\AccountController::class, 'store'])->name('admin.accounts.store');
        Route::put('/accounts/{id}', [\App\Http\Controllers\Admin\AccountController::class, 'update'])->name('admin.accounts.update');
        Route::delete('/accounts/{id}', [\App\Http\Controllers\Admin\AccountController::class, 'destroy'])->name('admin.accounts.destroy');
        
        // Announcements Management Routes
        Route::get('/announcements', [\App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('admin.announcements.index');
        Route::post('/announcements', [\App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('admin.announcements.store');
        Route::get('/announcements/{id}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'show'])->name('admin.announcements.show');
        Route::put('/announcements/{id}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('admin.announcements.update');
        Route::delete('/announcements/{id}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');
        
        Route::post('/update-profile-picture', [\App\Http\Controllers\Admin\UserManagementController::class, 'updateProfilePicture'])->name('admin.update-profile-picture');
    });
});
