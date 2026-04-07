<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING APPROVAL SYSTEM ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db",
        "postgres",
        "Alice2026@"
    );
    
    // Check current user statuses
    echo "🔍 CURRENT USER STATUSES:\n";
    $allStmt = $pdo->query("SELECT id, name, email, membership_status FROM users ORDER BY id");
    $allUsers = $allStmt->fetchAll();
    
    foreach ($allUsers as $user) {
        $statusIcon = $user['membership_status'] == 'Active' ? '✅' : 
                     ($user['membership_status'] == 'Pending' ? '⏳' : '❌');
        echo "{$statusIcon} ID: {$user['id']} - {$user['name']} - Status: {$user['membership_status']}\n";
    }
    
    // Reset all users to Pending for testing
    echo "\n🔄 RESETTING ALL USERS TO PENDING FOR TESTING:\n";
    $resetStmt = $pdo->prepare("UPDATE users SET membership_status = 'Pending' WHERE id != 7"); // Keep admin as Active
    $resetStmt->execute();
    $resetCount = $resetStmt->rowCount();
    echo "✅ Reset {$resetCount} users to Pending status\n";
    
    // Keep admin as Active
    $adminStmt = $pdo->prepare("UPDATE users SET membership_status = 'Active' WHERE id = 7");
    $adminStmt->execute();
    echo "✅ Kept admin (ID: 7) as Active\n";
    
    // Show updated statuses
    echo "\n📊 UPDATED STATUSES:\n";
    $updatedStmt = $pdo->query("SELECT id, name, email, membership_status FROM users ORDER BY id");
    $updatedUsers = $updatedStmt->fetchAll();
    
    foreach ($updatedUsers as $user) {
        $statusIcon = $user['membership_status'] == 'Active' ? '✅' : 
                     ($user['membership_status'] == 'Pending' ? '⏳' : '❌');
        echo "{$statusIcon} ID: {$user['id']} - {$user['name']} - Status: {$user['membership_status']}\n";
    }
    
    echo "\n🎯 NOW YOU CAN TEST:\n";
    echo "1. Go to admin dashboard\n";
    echo "2. Click 'Manage Users'\n";
    echo "3. You should see many users with 'Pending' status\n";
    echo "4. Click approve button for ONE user only\n";
    echo "5. Only that specific user should change to 'Active'\n";
    echo "6. Other users should remain 'Pending'\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
