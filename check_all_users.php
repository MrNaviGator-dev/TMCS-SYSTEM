<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK ALL USERS ORDERING ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Show all users with their IDs
    echo "All users in database (by ID order):\n";
    $stmt = $pdo->query("SELECT id, name, email, phone_number, created_at FROM users ORDER BY id ASC");
    $users = $stmt->fetchAll();
    
    if (count($users) > 0) {
        foreach ($users as $user) {
            echo "ID: {$user['id']} - {$user['name']} ({$user['email']}) - Phone: {$user['phone_number']} - Created: {$user['created_at']}\n";
        }
    } else {
        echo "No users found\n";
    }
    
    echo "\n=== SEQUENCE CHECK ===\n";
    $seqStmt = $pdo->query("SELECT * FROM users_id_seq");
    $seqInfo = $seqStmt->fetch();
    
    if ($seqInfo) {
        echo "Current sequence value: " . $seqInfo['last_value'] . "\n";
        echo "Is called: " . ($seqInfo['is_called'] ? 'YES' : 'NO') . "\n";
    }
    
    echo "\n=== NEXT ID TEST ===\n";
    $nextStmt = $pdo->query("SELECT nextval('users_id_seq') as next_id");
    $nextId = $nextStmt->fetch();
    echo "Next ID will be: {$nextId['next_id']}\n";
    
    // Reset back
    $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH " . $nextId['next_id']);
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
