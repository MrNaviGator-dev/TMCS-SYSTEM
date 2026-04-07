<?php
// Test with correct password from .env
try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    echo "=== SUCCESS! DATABASE CONNECTED ===\n\n";
    
    // Check if users table exists
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_name = 'users'");
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        echo "✅ Users table exists\n";
        
        // Count users
        $userStmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $userCount = $userStmt->fetch();
        echo "📊 Total users: {$userCount['count']}\n\n";
        
        // Show users with phone numbers for login testing
        echo "=== LOGIN TEST CREDENTIALS ===\n";
        $phoneStmt = $pdo->query("SELECT name, phone_number, email FROM users WHERE phone_number IS NOT NULL AND phone_number != '' LIMIT 5");
        $users = $phoneStmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) > 0) {
            foreach ($users as $user) {
                echo "👤 Name: {$user['name']}\n";
                echo "📱 Phone: {$user['phone_number']}\n";
                echo "📧 Email: {$user['email']}\n";
                echo "🔑 Password: (what you set during registration)\n";
                echo "------------------------\n";
            }
        } else {
            echo "❌ No users with phone numbers found\n";
            echo "💡 Please register a user first\n";
        }
        
    } else {
        echo "❌ Users table does not exist\n";
        echo "💡 Run: php artisan migrate\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Connection FAILED: " . $e->getMessage() . "\n";
}
?>
