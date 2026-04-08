<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check current session and admin user

echo "<!DOCTYPE html>
<html>
<head>
    <title>Profile Session Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-section { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
        .profile-img { max-width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
    </style>
</head>
<body>
    <h1>Profile Session Debug</h1>";

// Check session data
echo "<div class='debug-section'>
    <h3>Session Data</h3>
    <p><strong>Session Status:</strong> " . (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Not Active') . "</p>
    <p><strong>Session ID:</strong> " . session_id() . "</p>";

if (isset($_SESSION)) {
    echo "<p><strong>Session Data:</strong></p><pre>";
    print_r($_SESSION);
    echo "</pre>";
} else {
    echo "<p class='error'>No session data found</p>";
}

echo "</div>";

// Try to get current authenticated user
try {
    // Check if there's an authenticated user
    if (Illuminate\Support\Facades\Auth::check()) {
        $currentUser = Illuminate\Support\Facades\Auth::user();
        echo "<div class='debug-section'>
            <h3>Authenticated User</h3>
            <p><strong>ID:</strong> {$currentUser->id}</p>
            <p><strong>Name:</strong> {$currentUser->name}</p>
            <p><strong>Email:</strong> {$currentUser->email}</p>
            <p><strong>Role:</strong> {$currentUser->role}</p>
            <p><strong>Profile Picture:</strong> " . ($currentUser->profile_picture ?: 'NULL') . "</p>";
            
        if ($currentUser->profile_picture) {
            $imageUrl = asset('uploads/profiles/' . $currentUser->profile_picture);
            echo "<p><strong>Image URL:</strong> <a href='{$imageUrl}' target='_blank'>{$imageUrl}</a></p>";
            echo "<img src='{$imageUrl}' class='profile-img' 
                     onerror='this.style.border=\"2px solid red\"; this.nextSibling.innerHTML=\"Failed to load\";' 
                     onload='this.style.border=\"2px solid green\"; this.nextSibling.innerHTML=\"Loaded successfully\";'>";
            echo "<span class='info'>Loading...</span>";
        }
        
        echo "</div>";
    } else {
        echo "<div class='debug-section'>
            <h3>Authentication Status</h3>
            <p class='error'>No authenticated user found</p>
            <p>This might be the issue - the dashboard needs an authenticated user to load profile data.</p>
        </div>";
    }
} catch (Exception $e) {
    echo "<div class='debug-section'>
        <h3>Auth Error</h3>
        <p class='error'>Error checking authentication: " . $e->getMessage() . "</p>
    </div>";
}

// Show all admin users for comparison
echo "<div class='debug-section'>
    <h3>All Admin Users (for comparison)</h3>";

$adminUsers = \App\Models\User::where('role', 'admin')->get();
foreach ($adminUsers as $admin) {
    echo "<p><strong>{$admin->name} (ID: {$admin->id})</strong> - Profile: " . ($admin->profile_picture ?: 'NULL') . "</p>";
    
    if ($admin->profile_picture) {
        $imageUrl = asset('uploads/profiles/' . $admin->profile_picture);
        echo "<img src='{$imageUrl}' class='profile-img' style='max-width: 50px; height: 50px;' 
                 onerror='this.nextSibling.innerHTML=\"X\";' 
                 onload='this.nextSibling.innerHTML=\"OK\";'>";
        echo "<span class='info'>...</span> ";
    }
}

echo "</div>";

// Test the route that dashboard uses
echo "<div class='debug-section'>
    <h3>API Route Test</h3>";

try {
    // Simulate the API call that dashboard makes
    $route = route('admin.current-user');
    echo "<p><strong>Route URL:</strong> {$route}</p>";
    
    // Check if route exists
    if (\Illuminate\Support\Facades\Route::has('admin.current-user')) {
        echo "<p class='success'>Route exists</p>";
    } else {
        echo "<p class='error'>Route does not exist</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Route error: " . $e->getMessage() . "</p>";
}

echo "</div>";

echo "</body>
</html>";
?>
