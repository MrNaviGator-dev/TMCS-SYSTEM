<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DROP PETER COMMAND ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Find Peter
    echo "Searching for Peter...\n";
    $stmt = $pdo->query("SELECT id, name, email FROM users WHERE name ILIKE '%peter%' OR email ILIKE '%peter%'");
    $peterUsers = $stmt->fetchAll();
    
    if (count($peterUsers) > 0) {
        echo "Found Peter to delete:\n";
        foreach ($peterUsers as $peter) {
            echo "ID: {$peter['id']} - {$peter['name']} ({$peter['email']})\n";
        }
        
        // Delete Peter
        echo "\nDeleting Peter...\n";
        foreach ($peterUsers as $peter) {
            $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $deleteStmt->execute([$peter['id']]);
            echo "✅ DELETED: {$peter['name']} (ID: {$peter['id']})\n";
        }
        
        echo "\n✅ Peter has been successfully deleted!\n";
        
    } else {
        echo "❌ Peter not found in database\n";
    }
    
    // Show remaining users
    echo "\nRemaining users:\n";
    $remainingStmt = $pdo->query("SELECT id, name, email FROM users ORDER BY id");
    $remaining = $remainingStmt->fetchAll();
    
    foreach ($remaining as $user) {
        echo "ID: {$user['id']} - {$user['name']} ({$user['email']})\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
