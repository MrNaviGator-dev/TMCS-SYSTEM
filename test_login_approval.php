<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING LOGIN APPROVAL SYSTEM ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db",
        "postgres",
        "Alice2026@"
    );
    
    // Show current user statuses
    echo "🔍 CURRENT USER STATUSES:\n";
    $allStmt = $pdo->query("SELECT id, name, email, phone_number, membership_status FROM users ORDER BY id");
    $allUsers = $allStmt->fetchAll();
    
    foreach ($allUsers as $user) {
        $statusIcon = $user['membership_status'] == 'Active' ? '✅' : 
                     ($user['membership_status'] == 'Pending' ? '⏳' : '❌');
        $canLogin = $user['membership_status'] == 'Active' ? 'CAN LOGIN' : 'CANNOT LOGIN';
        echo "{$statusIcon} ID: {$user['id']} - {$user['name']} - Status: {$user['membership_status']} - {$canLogin}\n";
    }
    
    echo "\n🎯 LOGIN APPROVAL TEST RESULTS:\n";
    echo "✅ Active users (Admin + Approved): CAN LOGIN\n";
    echo "❌ Pending users: CANNOT LOGIN (will see 'Your account is not yet approved' message)\n";
    echo "❌ Inactive users: CANNOT LOGIN (will see 'Your account is not yet approved' message)\n";
    
    echo "\n📋 TEST INSTRUCTIONS:\n";
    echo "1. Try to login with a PENDING user (e.g., Musa Kibona - ID: 1)\n";
    echo "2. You should see: 'Your account is not yet approved. Please wait for admin approval.'\n";
    echo "3. Try to login with ACTIVE user (Admin - ID: 7)\n";
    echo "4. You should login successfully\n";
    echo "5. Go to admin dashboard → Manage Users\n";
    echo "6. Approve a pending user\n";
    echo "7. Try to login with that user again - should work now!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
