<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check announcement priority constraints
echo "Checking announcement priority constraints...\n";
echo "==========================================\n";

try {
    // Get check constraints for announcements table
    $constraints = \Illuminate\Support\Facades\DB::select("
        SELECT conname, consrc 
        FROM pg_constraint 
        WHERE conrelid = 'announcements'::regclass 
        AND contype = 'c'
    ");
    
    foreach ($constraints as $constraint) {
        echo "Constraint: {$constraint->conname}\n";
        echo "Definition: {$constraint->consrc}\n\n";
    }
    
    // Check existing priority values in database
    echo "Existing priority values:\n";
    $priorities = \Illuminate\Support\Facades\DB::table('announcements')
        ->distinct()
        ->pluck('priority')
        ->toArray();
    echo implode(', ', $priorities) . "\n\n";
    
    // Test valid priority values
    $testValues = ['low', 'medium', 'high', 'urgent', 'important'];
    foreach ($testValues as $value) {
        echo "Testing priority value: '{$value}'\n";
        try {
            $test = \Illuminate\Support\Facades\DB::select("
                SELECT '{$value}'::text AS test_priority 
                WHERE '{$value}' IN (low, medium, high, urgent, important)
            ");
            echo "✅ Valid\n";
        } catch (\Exception $e) {
            echo "❌ Invalid: " . $e->getMessage() . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
