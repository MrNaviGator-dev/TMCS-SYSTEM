<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK ALL USERS (FULL) ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Check total count
    $countStmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $total = $countStmt->fetch();
    echo "Total users in database: {$total['total']}\n\n";
    
    // Show all users
    echo "All users (by ID):\n";
    $stmt = $pdo->query("SELECT id, name, email, phone_number, role, created_at FROM users ORDER BY id");
    $users = $stmt->fetchAll();
    
    if (count($users) > 0) {
        foreach ($users as $user) {
            echo "ID: {$user['id']} - {$user['name']} - {$user['email']} - Role: {$user['role']} - Phone: {$user['phone_number']}\n";
        }
    } else {
        echo "No users found\n";
    }
    
    echo "\n=== SEQUENCE STATUS ===\n";
    $seqStmt = $pdo->query("SELECT last_value, is_called FROM users_id_seq");
    $seqInfo = $seqStmt->fetch();
    
    if ($seqInfo) {
        echo "Last sequence value: {$seqInfo['last_value']}\n";
        echo "Sequence called: " . ($seqInfo['is_called'] ? 'YES' : 'NO') . "\n";
        
        // Fix sequence to be after the highest ID
        if (count($users) > 0) {
            $maxId = max(array_column($users, 'id'));
            $nextId = $maxId + 1;
            
            echo "\nFixing sequence to start from: {$nextId}\n";
            $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH {$nextId}");
            echo "✅ Sequence fixed\n";
            
            // Test
            $testStmt = $pdo->query("SELECT nextval('users_id_seq') as test_id");
            $testId = $testStmt->fetch();
            echo "Test next ID: {$testId['test_id']}\n";
            
            // Reset back
            $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH {$nextId}");
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
