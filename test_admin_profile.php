<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test admin profile data
try {
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($user) {
        echo "Current Admin User Data:\n";
        echo "ID: " . $user->id . "\n";
        echo "Name: " . $user->name . "\n";
        echo "Email: " . $user->email . "\n";
        echo "Profile Picture: " . ($user->profile_picture ?: 'NULL') . "\n";
        echo "Role: " . $user->role . "\n";
        
        // Check if profile picture file exists
        if ($user->profile_picture) {
            $profilePath = public_path('uploads/profiles/' . $user->profile_picture);
            echo "Profile picture path: " . $profilePath . "\n";
            echo "File exists: " . (file_exists($profilePath) ? 'YES' : 'NO') . "\n";
        }
        
        // Test asset URL generation
        echo "\nAsset URL Tests:\n";
        echo "Default avatar path: " . asset('uploads/profiles/default-avatar.svg') . "\n";
        echo "Default avatar PNG path: " . asset('uploads/profiles/default-avatar.png') . "\n";
        
        // List some profile files
        echo "\nProfile files in uploads/profiles:\n";
        $files = glob(public_path('uploads/profiles/*'));
        foreach (array_slice($files, 0, 5) as $file) {
            echo "- " . basename($file) . "\n";
        }
        
    } else {
        echo "No authenticated user found.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
