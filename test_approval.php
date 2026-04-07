<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING APPROVAL SYSTEM ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db",
        "postgres",
        "Alice2026@"
    );
    
    // Check pending users
    echo "🔍 CHECKING PENDING USERS:\n";
    $pendingStmt = $pdo->query("SELECT id, name, email, membership_status FROM users WHERE membership_status = 'Pending'");
    $pendingUsers = $pendingStmt->fetchAll();
    
    if (count($pendingUsers) > 0) {
        echo "✅ Found " . count($pendingUsers) . " pending users:\n";
        foreach ($pendingUsers as $user) {
            echo "👤 ID: {$user['id']} - {$user['name']} ({$user['email']}) - Status: {$user['membership_status']}\n";
        }
        
        // Test approval for first pending user
        $testUser = $pendingUsers[0];
        echo "\n🔄 TESTING APPROVAL FOR USER ID: {$testUser['id']}\n";
        
        $updateStmt = $pdo->prepare("UPDATE users SET membership_status = 'Active' WHERE id = ?");
        $updateStmt->execute([$testUser['id']]);
        
        echo "✅ User {$testUser['name']} status updated to Active\n";
        
        // Verify the change
        $verifyStmt = $pdo->prepare("SELECT membership_status FROM users WHERE id = ?");
        $verifyStmt->execute([$testUser['id']]);
        $status = $verifyStmt->fetchColumn();
        
        echo "🔍 VERIFIED: User status is now: {$status}\n";
        
    } else {
        echo "❌ No pending users found\n";
        
        // Create a test pending user
        echo "\n➕ CREATING TEST PENDING USER:\n";
        $insertStmt = $pdo->prepare("
            INSERT INTO users (name, email, phone_number, password, role, membership_status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $insertStmt->execute([
            'Test Pending User',
            'testpending@example.com',
            '255712345678',
            password_hash('password123', PASSWORD_DEFAULT),
            'member',
            'Pending',
            date('Y-m-d H:i:s')
        ]);
        
        $newUserId = $pdo->lastInsertId();
        echo "✅ Created test pending user with ID: {$newUserId}\n";
    }
    
    // Show all users with their status
    echo "\n📊 ALL USERS WITH STATUS:\n";
    $allStmt = $pdo->query("SELECT id, name, email, membership_status FROM users ORDER BY id");
    $allUsers = $allStmt->fetchAll();
    
    foreach ($allUsers as $user) {
        $statusIcon = $user['membership_status'] == 'Active' ? '✅' : 
                     ($user['membership_status'] == 'Pending' ? '⏳' : '❌');
        echo "{$statusIcon} ID: {$user['id']} - {$user['name']} - Status: {$user['membership_status']}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
