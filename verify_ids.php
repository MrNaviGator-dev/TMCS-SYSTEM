<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFY ID SEQUENCE ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Show current users
    echo "Current users in database:\n";
    $stmt = $pdo->query("SELECT id, name, email, phone_number FROM users ORDER BY id");
    $users = $stmt->fetchAll();
    
    if (count($users) > 0) {
        foreach ($users as $user) {
            echo "ID: {$user['id']} - {$user['name']} ({$user['email']})\n";
        }
    } else {
        echo "No users yet. Ready for registration!\n";
    }
    
    echo "\nNext ID will be: ";
    $nextStmt = $pdo->query("SELECT nextval('users_id_seq') as next_id");
    $nextId = $nextStmt->fetch();
    echo $nextId['next_id'] . "\n";
    
    // Reset back since we just consumed one
    $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH " . $nextId['next_id']);
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
