<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FIX ID SEQUENCE ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Check current sequence using PostgreSQL specific query
    echo "1. Checking current sequence:\n";
    $stmt = $pdo->query("SELECT * FROM users_id_seq");
    $seqInfo = $stmt->fetch();
    
    if ($seqInfo) {
        echo "   Current sequence value: " . $seqInfo['last_value'] . "\n";
        echo "   Is called: " . ($seqInfo['is_called'] ? 'YES' : 'NO') . "\n";
    } else {
        echo "   ❌ Sequence not found\n";
    }
    
    echo "\n2. Resetting sequence to start from 1:\n";
    
    // Reset sequence
    $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH 1");
    echo "   ✅ Sequence reset to 1\n";
    
    // Verify the reset
    $verifyStmt = $pdo->query("SELECT * FROM users_id_seq");
    $verifyInfo = $verifyStmt->fetch();
    
    if ($verifyInfo) {
        echo "   ✅ Verified: Sequence now starts from " . $verifyInfo['last_value'] . "\n";
    }
    
    echo "\n3. Testing next ID:\n";
    $testStmt = $pdo->query("SELECT nextval('users_id_seq') as next_id");
    $nextId = $testStmt->fetch();
    echo "   Next ID will be: {$nextId['next_id']}\n";
    
    // Reset back since we just consumed one
    $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH 1");
    echo "   ✅ Reset back to 1 for actual use\n";
    
    echo "\n✅ ID sequence is now properly configured!\n";
    echo "   New users will start from ID = 1\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
