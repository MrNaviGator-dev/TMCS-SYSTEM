<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== UPDATE USER REGISTRATION STATUS TO PENDING ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db",
        "postgres",
        "Alice2026@"
    );
    
    // Update all users to have 'Pending' status by default
    echo "🔄 UPDATING ALL USERS TO PENDING STATUS:\n";
    
    $updateStmt = $pdo->prepare("
        UPDATE users 
        SET membership_status = 'Pending' 
        WHERE membership_status IS NULL OR membership_status = ''
    ");
    $updateStmt->execute();
    
    $affectedRows = $updateStmt->rowCount();
    echo "✅ Updated {$affectedRows} users to 'Pending' status\n";
    
    // Show current status distribution
    echo "\n📊 CURRENT STATUS DISTRIBUTION:\n";
    $statusStmt = $pdo->query("
        SELECT membership_status, COUNT(*) as count 
        FROM users 
        GROUP BY membership_status 
        ORDER BY count DESC
    ");
    $statusCounts = $statusStmt->fetchAll();
    
    foreach ($statusCounts as $status) {
        $statusName = $status['membership_status'] ?: 'NULL';
        echo "👥 {$statusName}: {$status['count']} users\n";
    }
    
    // Show all users with their current status
    echo "\n👤 ALL USERS WITH CURRENT STATUS:\n";
    $usersStmt = $pdo->query("
        SELECT id, name, email, phone_number, role, membership_status, created_at
        FROM users 
        ORDER BY id ASC
    ");
    $users = $usersStmt->fetchAll();
    
    foreach ($users as $user) {
        echo "\n🔹 ID: {$user['id']} - {$user['name']}\n";
        echo "   📧 {$user['email']}\n";
        echo "   📱 " . ($user['phone_number'] ?: 'Not set') . "\n";
        echo "   👑 Role: {$user['role']}\n";
        echo "   ✅ Status: " . ($user['membership_status'] ?: 'Not set') . "\n";
        echo "   📅 Joined: {$user['created_at']}\n";
    }
    
    echo "\n✅ ALL NEW REGISTRATIONS WILL NOW DEFAULT TO 'PENDING'!";
    echo "\n📋 Admin must approve each user manually to change status to 'Active'\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
