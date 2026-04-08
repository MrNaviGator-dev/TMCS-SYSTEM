<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test profile image loading
try {
    $adminUsers = \App\Models\User::where('role', 'admin')->get();
    
    echo "<!DOCTYPE html>
<html>
<head>
    <title>Profile Image Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .profile-test { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .profile-img { max-width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Profile Image Loading Test</h1>";
    
    foreach ($adminUsers as $admin) {
        echo "<div class='profile-test'>
            <h3>Admin: {$admin->name}</h3>
            <p><strong>Email:</strong> {$admin->email}</p>
            <p><strong>Profile Picture:</strong> " . ($admin->profile_picture ?: 'NULL') . "</p>";
            
        if ($admin->profile_picture) {
            $imageUrl = asset('uploads/profiles/' . $admin->profile_picture);
            $filePath = public_path('uploads/profiles/' . $admin->profile_picture);
            
            echo "<p><strong>Image URL:</strong> <a href='{$imageUrl}' target='_blank'>{$imageUrl}</a></p>";
            echo "<p><strong>File Path:</strong> {$filePath}</p>";
            echo "<p><strong>File Exists:</strong> " . (file_exists($filePath) ? '<span class=\"success\">YES</span>' : '<span class=\"error\">NO</span>') . "</p>";
            
            echo "<p><strong>Image Test:</strong></p>";
            echo "<img src='{$imageUrl}' class='profile-img' 
                     onerror='this.style.border=\"2px solid red\"; this.nextSibling.innerHTML=\"Failed to load\";' 
                     onload='this.style.border=\"2px solid green\"; this.nextSibling.innerHTML=\"Loaded successfully\";'>";
            echo "<span class='info'>Loading...</span>";
        } else {
            echo "<p><span class='error'>No profile picture set</span></p>";
            echo "<p><strong>Fallback Test:</strong></p>";
            echo "<img src='" . asset('uploads/profiles/default-avatar.svg') . "' class='profile-img' 
                     onerror='this.style.border=\"2px solid red\"; this.nextSibling.innerHTML=\"Fallback failed\";' 
                     onload='this.style.border=\"2px solid green\"; this.nextSibling.innerHTML=\"Fallback loaded\";'>";
            echo "<span class='info'>Loading fallback...</span>";
        }
        
        echo "</div>";
    }
    
    echo "<div class='profile-test'>
        <h3>Default Avatar Tests</h3>
        <p><strong>SVG Fallback:</strong></p>
        <img src='" . asset('uploads/profiles/default-avatar.svg') . "' class='profile-img' 
             onerror='this.nextSibling.innerHTML=\"SVG failed\";' 
             onload='this.nextSibling.innerHTML=\"SVG loaded successfully\";'>
        <span class='info'>Loading SVG...</span>
        
        <p><strong>PNG Fallback:</strong></p>
        <img src='" . asset('uploads/profiles/default-avatar.png') . "' class='profile-img' 
             onerror='this.nextSibling.innerHTML=\"PNG failed\";' 
             onload='this.nextSibling.innerHTML=\"PNG loaded successfully\";'>
        <span class='info'>Loading PNG...</span>
    </div>
    
    <div class='profile-test'>
        <h3>Debug Information</h3>
        <p><strong>Base URL:</strong> " . url('/') . "</p>
        <p><strong>Asset URL:</strong> " . asset('uploads/profiles/') . "</p>
        <p><strong>Public Path:</strong> " . public_path() . "</p>
        <p><strong>Uploads Path:</strong> " . public_path('uploads/profiles/') . "</p>
    </div>
    
</body>
</html>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
