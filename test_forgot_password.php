<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FORGOT PASSWORD FUNCTIONALITY ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Get the user's phone number
    $stmt = $pdo->query("SELECT phone_number FROM users LIMIT 1");
    $user = $stmt->fetch();
    
    if ($user) {
        $phoneNumber = $user['phone_number'];
        echo "Testing with phone number: {$phoneNumber}\n\n";
        
        // Test 1: Direct database lookup
        echo "1. Direct database lookup:\n";
        $lookupStmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE phone_number = ?");
        $lookupStmt->execute([$phoneNumber]);
        $result = $lookupStmt->fetch();
        echo "   Found: {$result['count']} user(s)\n";
        
        // Test 2: Laravel User model lookup
        echo "\n2. Laravel User model lookup:\n";
        try {
            $userModel = \App\Models\User::where('phone_number', $phoneNumber)->first();
            if ($userModel) {
                echo "   ✅ Found user: {$userModel->name}\n";
                echo "   ✅ Email: {$userModel->email}\n";
                echo "   ✅ Phone: {$userModel->phone_number}\n";
            } else {
                echo "   ❌ User not found\n";
            }
        } catch (Exception $e) {
            echo "   ❌ Error: " . $e->getMessage() . "\n";
        }
        
        // Test 3: Simulate form submission
        echo "\n3. Simulate form submission:\n";
        $_POST['phone_number'] = $phoneNumber;
        $_POST['_token'] = 'test';
        
        try {
            $user = \App\Models\User::where('phone_number', $_POST['phone_number'])->first();
            if ($user) {
                echo "   ✅ Form simulation successful\n";
                echo "   ✅ User found: {$user->name}\n";
            } else {
                echo "   ❌ Form simulation failed\n";
            }
        } catch (Exception $e) {
            echo "   ❌ Error: " . $e->getMessage() . "\n";
        }
        
        echo "\n=== TROUBLESHOOTING TIPS ===\n";
        echo "1. Make sure you're entering: {$phoneNumber}\n";
        echo "2. Check for extra spaces or characters\n";
        echo "3. Try copying and pasting the number\n";
        echo "4. Ensure the forgot password form is submitting correctly\n";
        
    } else {
        echo "❌ No users found in database\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
