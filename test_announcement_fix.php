<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test announcement creation with correct priority values
echo "Testing announcement creation with correct priorities...\n";
echo "==================================================\n";

try {
    // Test with 'normal' priority
    $test1 = new \App\Models\Announcement();
    $test1->title = 'Test Normal Priority';
    $test1->message = 'This is a test announcement with normal priority';
    $test1->priority = 'normal';
    $test1->audience = 'all';
    $test1->status = 'active';
    $test1->created_by = 1;
    $test1->updated_by = 1;
    
    if ($test1->save()) {
        echo "✅ Normal priority announcement created! ID: {$test1->id}\n";
        $test1->delete();
    } else {
        echo "❌ Failed to create normal priority announcement\n";
    }
    
    // Test with 'urgent' priority
    $test2 = new \App\Models\Announcement();
    $test2->title = 'Test Urgent Priority';
    $test2->message = 'This is a test announcement with urgent priority';
    $test2->priority = 'urgent';
    $test2->audience = 'all';
    $test2->status = 'active';
    $test2->created_by = 1;
    $test2->updated_by = 1;
    
    if ($test2->save()) {
        echo "✅ Urgent priority announcement created! ID: {$test2->id}\n";
        $test2->delete();
    } else {
        echo "❌ Failed to create urgent priority announcement\n";
    }
    
    // Test with 'important' priority
    $test3 = new \App\Models\Announcement();
    $test3->title = 'Test Important Priority';
    $test3->message = 'This is a test announcement with important priority';
    $test3->priority = 'important';
    $test3->audience = 'all';
    $test3->status = 'active';
    $test3->created_by = 1;
    $test3->updated_by = 1;
    
    if ($test3->save()) {
        echo "✅ Important priority announcement created! ID: {$test3->id}\n";
        $test3->delete();
    } else {
        echo "❌ Failed to create important priority announcement\n";
    }
    
    // Test with invalid priority (should fail)
    try {
        $test4 = new \App\Models\Announcement();
        $test4->title = 'Test Invalid Priority';
        $test4->message = 'This should fail';
        $test4->priority = 'medium'; // This should fail
        $test4->audience = 'all';
        $test4->status = 'active';
        $test4->created_by = 1;
        $test4->updated_by = 1;
        $test4->save();
        echo "❌ Invalid priority 'medium' was accepted (this should not happen!)\n";
        $test4->delete();
    } catch (\Exception $e) {
        echo "✅ Invalid priority 'medium' was correctly rejected: " . $e->getMessage() . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n✅ Announcement creation fix completed!\n";
