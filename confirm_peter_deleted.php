<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CONFIRM PETER DELETED ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Check if Peter exists
    echo "Searching for Peter in database...\n";
    $stmt = $pdo->query("SELECT id, name, email FROM users WHERE name ILIKE '%peter%' OR email ILIKE '%peter%'");
    $peterUsers = $stmt->fetchAll();
    
    if (count($peterUsers) > 0) {
        echo "Found Peter(s):\n";
        foreach ($peterUsers as $peter) {
            echo "ID: {$peter['id']} - {$peter['name']} ({$peter['email']})\n";
        }
        
        echo "\nDeleting Peter...\n";
        foreach ($peterUsers as $peter) {
            $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $deleteStmt->execute([$peter['id']]);
            echo "✅ Deleted: {$peter['name']} (ID: {$peter['id']})\n";
        }
    } else {
        echo "✅ Peter not found in database\n";
    }
    
    // Show remaining users
    echo "\nRemaining users:\n";
    $allStmt = $pdo->query("SELECT id, name, email FROM users ORDER BY id");
    $allUsers = $allStmt->fetchAll();
    
    if (count($allUsers) > 0) {
        foreach ($allUsers as $user) {
            echo "ID: {$user['id']} - {$user['name']} ({$user['email']})\n";
        }
    } else {
        echo "No users remaining\n";
    }
    
    // Fix sequence
    if (count($allUsers) > 0) {
        $maxId = max(array_column($allUsers, 'id'));
        $nextId = $maxId + 1;
        $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH {$nextId}");
        echo "\n✅ Sequence fixed: Next ID = {$nextId}\n";
    } else {
        $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH 1");
        echo "\n✅ Sequence reset: Next ID = 1\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
