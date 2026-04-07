<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG LOGIN ERROR ===\n\n";

// Test 1: Check if we can connect to database
echo "1. Testing database connection...\n";
try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "1234"
    );
    echo "   ✅ Database connection: SUCCESS\n";
    
    // Test 2: Check if users table exists
    echo "2. Checking users table...\n";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_name = 'users'");
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        echo "   ✅ Users table exists\n";
        
        // Test 3: Count users
        echo "3. Counting users...\n";
        $userStmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $userCount = $userStmt->fetch();
        echo "   📊 Total users: {$userCount['count']}\n";
        
        // Test 4: Show users with phone numbers
        echo "4. Showing users with phone numbers...\n";
        $phoneStmt = $pdo->query("SELECT name, phone_number, email FROM users WHERE phone_number IS NOT NULL AND phone_number != ''");
        $users = $phoneStmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) > 0) {
            foreach ($users as $user) {
                echo "   👤 {$user['name']} - {$user['phone_number']} - {$user['email']}\n";
            }
        } else {
            echo "   ❌ No users with phone numbers found\n";
        }
        
    } else {
        echo "   ❌ Users table does not exist\n";
        echo "   💡 Run: php artisan migrate\n";
    }
    
} catch (PDOException $e) {
    echo "   ❌ Database connection FAILED: " . $e->getMessage() . "\n";
    echo "   💡 Check:\n";
    echo "      - PostgreSQL service running?\n";
    echo "      - Database 'tmcs_system' exists?\n";
    echo "      - Password correct?\n";
}

echo "\n=== LOGIN FORM TEST ===\n";
echo "Try these test credentials:\n";

// Try to get sample users for testing
try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "1234"
    );
    
    $stmt = $pdo->query("SELECT name, phone_number FROM users LIMIT 3");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "Test with these phone numbers:\n";
        foreach ($users as $user) {
            echo "   Phone: {$user['phone_number']} (User: {$user['name']})\n";
        }
        echo "   Password: (whatever you set during registration)\n";
    } else {
        echo "❌ No users found. Please register first.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Cannot get test users: " . $e->getMessage() . "\n";
}
?>
