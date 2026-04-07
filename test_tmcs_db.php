<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING TMCS_DB DATABASE ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db",
        "postgres",
        "Alice2026@"
    );
    
    echo "✅ Connected to tmcs_db database!\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_name = 'users'");
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        echo "✅ Users table exists\n";
        
        // Count users
        $userStmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $userCount = $userStmt->fetch();
        echo "📊 Total users: {$userCount['count']}\n";
        
        // Show users
        if ($userCount['count'] > 0) {
            echo "\n👥 Users in tmcs_db:\n";
            $usersStmt = $pdo->query("SELECT id, name, phone_number, email FROM users ORDER BY id");
            $users = $usersStmt->fetchAll();
            
            foreach ($users as $user) {
                echo "ID: {$user['id']} - {$user['name']} ({$user['email']}) - {$user['phone_number']}\n";
            }
        }
        
    } else {
        echo "❌ Users table not found\n";
        echo "💡 Run: php artisan migrate\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    
    if (strpos($e->getMessage(), 'does not exist') !== false) {
        echo "💡 Database 'tmcs_db' does not exist. Creating...\n";
        
        try {
            // Connect to default postgres database
            $defaultPdo = new PDO(
                "pgsql:host=127.0.0.1;port=5432;dbname=postgres",
                "postgres",
                "Alice2026@"
            );
            
            $defaultPdo->exec("CREATE DATABASE tmcs_db");
            echo "✅ Database 'tmcs_db' created successfully!\n";
            
            // Run migrations
            echo "🔄 Running migrations...\n";
            passthru("php artisan migrate --force");
            
        } catch (Exception $e2) {
            echo "❌ Failed to create database: " . $e2->getMessage() . "\n";
        }
    }
}
?>
