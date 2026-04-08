<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test the getCurrentUser API endpoint
echo "<!DOCTYPE html>
<html>
<head>
    <title>Admin Current User Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
        .profile-img { max-width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
    </style>
</head>
<body>
    <h1>Admin Current User API Test</h1>";

// Test 1: Check if we can simulate the API call
echo "<div class='test-section'>
    <h3>Test 1: Simulate API Call</h3>";

try {
    // Simulate getting current user (this would normally come from auth)
    $user = \App\Models\User::where('role', 'admin')->first();
    
    if ($user) {
        echo "<p><strong>Found Admin:</strong> {$user->name} (ID: {$user->id})</p>";
        echo "<p><strong>Profile Picture:</strong> " . ($user->profile_picture ?: 'NULL') . "</p>";
        
        // Simulate the JSON response that the API would return
        $apiResponse = [
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'role' => $user->role,
                'membership_status' => $user->membership_status
            ]
        ];
        
        echo "<p><strong>API Response:</strong></p><pre>";
        echo json_encode($apiResponse, JSON_PRETTY_PRINT);
        echo "</pre>";
        
        // Test what JavaScript would receive
        echo "<p><strong>JavaScript Simulation:</strong></p>";
        echo "<div id='profileTest'></div>";
        
        echo "<script>
            const user = " . json_encode($apiResponse['user']) . ";
            console.log('=== PROFILE DEBUG ===');
            console.log('User data:', user);
            console.log('Profile picture path:', user.profile_picture);
            console.log('Profile picture exists:', !!user.profile_picture);
            
            if (user.profile_picture) {
                const imageUrl = 'http://localhost/uploads/profiles/' + user.profile_picture;
                console.log('Full image URL:', imageUrl);
                
                // Test if image loads
                const testImg = new Image();
                testImg.onload = function() {
                    console.log('Image loads successfully:', imageUrl);
                    document.getElementById('profileTest').innerHTML = 
                        '<p class=\"success\">Image loads successfully: ' + imageUrl + '</p>' +
                        '<img src=\"' + imageUrl + '\" class=\"profile-img\" style=\"border: 2px solid green;\">';
                };
                testImg.onerror = function() {
                    console.error('Image fails to load:', imageUrl);
                    document.getElementById('profileTest').innerHTML = 
                        '<p class=\"error\">Image fails to load: ' + imageUrl + '</p>' +
                        '<img src=\"http://localhost/uploads/profiles/default-avatar.svg\" class=\"profile-img\" style=\"border: 2px solid orange;\">';
                };
                testImg.src = imageUrl;
            } else {
                console.log('No profile picture, using fallback');
                document.getElementById('profileTest').innerHTML = 
                    '<p class=\"info\">No profile picture, using fallback</p>' +
                    '<img src=\"http://localhost/uploads/profiles/default-avatar.svg\" class=\"profile-img\" style=\"border: 2px solid blue;\">';
            }
            console.log('==================');
        </script>";
        
    } else {
        echo "<p class='error'>No admin user found</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test 2: Check all admin users and their profile pictures
echo "<div class='test-section'>
    <h3>Test 2: All Admin Users Profile Check</h3>";

$adminUsers = \App\Models\User::where('role', 'admin')->get();
foreach ($adminUsers as $admin) {
    echo "<div style='margin: 10px 0; padding: 10px; border: 1px solid #ddd;'>";
    echo "<p><strong>{$admin->name} (ID: {$admin->id})</strong></p>";
    echo "<p>Profile Picture: " . ($admin->profile_picture ?: 'NULL') . "</p>";
    
    if ($admin->profile_picture) {
        $imageUrl = asset('uploads/profiles/' . $admin->profile_picture);
        $filePath = public_path('uploads/profiles/' . $admin->profile_picture);
        echo "<p>File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "</p>";
        echo "<img src='{$imageUrl}' class='profile-img' 
                 onerror='this.style.border=\"2px solid red\"; this.nextSibling.innerHTML=\"FAILED\";' 
                 onload='this.style.border=\"2px solid green\"; this.nextSibling.innerHTML=\"OK\";'>";
        echo "<span class='info'>...</span>";
    } else {
        echo "<p class='error'>This admin has no profile picture - will show symbol</p>";
        echo "<img src='http://localhost/uploads/profiles/default-avatar.svg' class='profile-img' style='border: 2px solid blue;'>";
    }
    echo "</div>";
}

echo "</div>";

echo "</body>
</html>";
?>
