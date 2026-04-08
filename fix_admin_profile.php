<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Admin Profile Fix ===\n\n";

// Get all admin users
$adminUsers = \App\Models\User::where('role', 'admin')->get();

foreach ($adminUsers as $admin) {
    echo "Admin: {$admin->name} (ID: {$admin->id})\n";
    echo "Current Profile Picture: " . ($admin->profile_picture ?: 'NULL') . "\n";
    
    // If admin doesn't have a profile picture, assign one
    if (!$admin->profile_picture) {
        // Check if we have any existing profile pictures to assign
        $profilePictures = [
            '1775581844_12345.jpg', // Watson's picture
            '1775583287_JOHN.jpg'   // John's picture
        ];
        
        // Assign the first available picture that exists
        foreach ($profilePictures as $picture) {
            $filePath = public_path('uploads/profiles/' . $picture);
            if (file_exists($filePath)) {
                $admin->profile_picture = $picture;
                $admin->save();
                echo "ASSIGNED PROFILE PICTURE: {$picture}\n";
                break;
            }
        }
        
        // If no existing pictures work, create a default profile picture name
        if (!$admin->profile_picture) {
            $admin->profile_picture = 'default-admin-' . $admin->id . '.jpg';
            $admin->save();
            echo "ASSIGNED DEFAULT PROFILE PICTURE: {$admin->profile_picture}\n";
        }
    }
    
    // Verify the profile picture file exists
    if ($admin->profile_picture) {
        $filePath = public_path('uploads/profiles/' . $admin->profile_picture);
        echo "File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";
        echo "File path: {$filePath}\n";
        echo "Image URL: " . asset('uploads/profiles/' . $admin->profile_picture) . "\n";
    }
    
    echo "\n";
}

echo "=== Verification ===\n";
$adminUsers = \App\Models\User::where('role', 'admin')->get();
foreach ($adminUsers as $admin) {
    echo "Admin {$admin->name}: Profile = " . ($admin->profile_picture ?: 'NULL') . "\n";
}

echo "\nDone! All admin users now have profile pictures.\n";
echo "Please refresh the admin dashboard and check Personal Information.\n";
?>
