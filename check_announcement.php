<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check announcements table
echo "Checking announcements table...\n";
echo "============================\n";

try {
    $announcements = \App\Models\Announcement::count();
    echo "Total announcements: {$announcements}\n";
    
    // Check table structure
    $schema = \Illuminate\Support\Facades\Schema::getColumnListing('announcements');
    echo "Table columns: " . implode(', ', $schema) . "\n";
    
    // Check if we can create a test announcement
    echo "\nTesting announcement creation...\n";
    $testAnnouncement = new \App\Models\Announcement();
    $testAnnouncement->title = 'Test Announcement';
    $testAnnouncement->message = 'Test message';
    $testAnnouncement->priority = 'medium';
    $testAnnouncement->audience = 'all';
    $testAnnouncement->status = 'active';
    $testAnnouncement->created_by = 1; // Assuming user ID 1 exists
    $testAnnouncement->updated_by = 1;
    
    if ($testAnnouncement->save()) {
        echo "✅ Test announcement created successfully! ID: {$testAnnouncement->id}\n";
        $testAnnouncement->delete(); // Clean up
    } else {
        echo "❌ Failed to create test announcement\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

// Check storage directory
echo "\nChecking storage directory...\n";
echo "============================\n";
$storagePath = storage_path('app/public/announcements');
echo "Storage path: {$storagePath}\n";
echo "Directory exists: " . (is_dir($storagePath) ? 'Yes' : 'No') . "\n";
echo "Is writable: " . (is_writable($storagePath) ? 'Yes' : 'No') . "\n";

// Create directory if it doesn't exist
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
    echo "✅ Created announcements directory\n";
}
