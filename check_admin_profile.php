<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check admin users in database
try {
    $adminUsers = \App\Models\User::where('role', 'admin')->get();
    
    echo "Admin Users in Database:\n";
    echo "======================\n";
    
    foreach ($adminUsers as $admin) {
        echo "\nAdmin ID: " . $admin->id . "\n";
        echo "Name: " . $admin->name . "\n";
        echo "Email: " . $admin->email . "\n";
        echo "Profile Picture: " . ($admin->profile_picture ?: 'NULL') . "\n";
        
        // Check if profile picture file exists
        if ($admin->profile_picture) {
            $profilePath = public_path('uploads/profiles/' . $admin->profile_picture);
            echo "Profile picture path: " . $profilePath . "\n";
            echo "File exists: " . (file_exists($profilePath) ? 'YES' : 'NO') . "\n";
        }
        
        // Test what the image URL would be
        if ($admin->profile_picture) {
            echo "Image URL: " . asset('uploads/profiles/' . $admin->profile_picture) . "\n";
        }
    }
    
    echo "\nDefault avatar files:\n";
    echo "====================\n";
    $defaultSvg = public_path('uploads/profiles/default-avatar.svg');
    $defaultPng = public_path('uploads/profiles/default-avatar.png');
    
    echo "SVG exists: " . (file_exists($defaultSvg) ? 'YES' : 'NO') . "\n";
    echo "PNG exists: " . (file_exists($defaultPng) ? 'YES' : 'NO') . "\n";
    
    echo "\nAsset URL tests:\n";
    echo "SVG URL: " . asset('uploads/profiles/default-avatar.svg') . "\n";
    echo "PNG URL: " . asset('uploads/profiles/default-avatar.png') . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
