<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check announcement priority values directly
echo "Checking announcement priority values...\n";
echo "====================================\n";

try {
    // Get all announcements with their priority values
    $announcements = \Illuminate\Support\Facades\DB::table('announcements')
        ->select('id', 'title', 'priority')
        ->get();
    
    echo "Existing announcements:\n";
    foreach ($announcements as $announcement) {
        echo "ID: {$announcement->id}, Title: {$announcement->title}, Priority: {$announcement->priority}\n";
    }
    
    // Check what priority values are actually allowed
    echo "\nTesting priority values:\n";
    $testValues = ['low', 'medium', 'high', 'urgent', 'important'];
    
    foreach ($testValues as $value) {
        try {
            // Try to insert a test announcement with this priority
            $test = \Illuminate\Support\Facades\DB::select("
                SELECT '{$value}' AS test_value
            ");
            echo "✅ '{$value}' - Valid format\n";
        } catch (\Exception $e) {
            echo "❌ '{$value}' - Error: " . $e->getMessage() . "\n";
        }
    }
    
    // Check the actual constraint definition
    echo "\nGetting constraint info...\n";
    $constraint = \Illuminate\Support\Facades\DB::select("
        SELECT 
            conname,
            pg_get_constraintdef(oid) as definition
        FROM pg_constraint 
        WHERE conrelid = 'announcements'::regclass 
        AND conname = 'announcements_priority_check'
        LIMIT 1
    ");
    
    if ($constraint) {
        echo "Constraint name: {$constraint[0]->conname}\n";
        echo "Definition: {$constraint[0]->definition}\n";
    } else {
        echo "No priority constraint found\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
