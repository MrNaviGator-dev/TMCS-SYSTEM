<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG PHONE NUMBERS ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Show all users with their phone numbers
    echo "All users and their phone numbers:\n";
    $stmt = $pdo->query("SELECT id, name, phone_number, email FROM users ORDER BY id");
    $users = $stmt->fetchAll();
    
    if (count($users) > 0) {
        foreach ($users as $user) {
            echo "ID: {$user['id']} - {$user['name']}\n";
            echo "   Phone: '" . $user['phone_number'] . "'\n";
            echo "   Email: {$user['email']}\n";
            echo "------------------------\n";
        }
    } else {
        echo "No users found\n";
    }
    
    echo "\n=== TEST PHONE NUMBER LOOKUP ===\n";
    
    // Test each phone number format
    foreach ($users as $user) {
        if ($user['phone_number']) {
            echo "\nTesting phone: '{$user['phone_number']}'\n";
            
            // Test exact match
            $exactStmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE phone_number = ?");
            $exactStmt->execute([$user['phone_number']]);
            $exact = $exactStmt->fetch();
            echo "   Exact match: {$exact['count']} users found\n";
            
            // Test with different formats
            $phoneFormats = [
                $user['phone_number'],
                trim($user['phone_number']),
                ltrim($user['phone_number'], '0'),
                '+255' . substr($user['phone_number'], -9),
                '0' . substr($user['phone_number'], -9)
            ];
            
            foreach ($phoneFormats as $format) {
                $testStmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE phone_number = ?");
                $testStmt->execute([$format]);
                $test = $testStmt->fetch();
                if ($test['count'] > 0) {
                    echo "   ✅ Format '{$format}' works\n";
                }
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
