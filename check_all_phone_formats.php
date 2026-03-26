<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK ALL PHONE FORMATS ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Get all users
    $stmt = $pdo->query("SELECT id, name, phone_number, email FROM users ORDER BY id");
    $users = $stmt->fetchAll();
    
    echo "All users in database:\n";
    foreach ($users as $user) {
        echo "ID: {$user['id']} - {$user['name']}\n";
        echo "   Phone: '" . $user['phone_number'] . "'\n";
        echo "   Email: {$user['email']}\n";
        echo "------------------------\n";
    }
    
    echo "\n=== TEST DIFFERENT PHONE FORMATS ===\n";
    
    // Test each user with different formats
    foreach ($users as $user) {
        if ($user['phone_number']) {
            echo "\nTesting user: {$user['name']}\n";
            
            $originalPhone = $user['phone_number'];
            
            // Test different formats
            $formats = [
                'Original' => $originalPhone,
                'Trimmed' => trim($originalPhone),
                'No leading zeros' => ltrim($originalPhone, '0'),
                'With +255' => '+255' . substr($originalPhone, -9),
                'With 0 prefix' => '0' . substr($originalPhone, -9),
                'Last 9 digits' => substr($originalPhone, -9),
                'Without 255' => substr($originalPhone, 3),
            ];
            
            foreach ($formats as $formatName => $phoneFormat) {
                $testStmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE phone_number = ?");
                $testStmt->execute([$phoneFormat]);
                $result = $testStmt->fetch();
                
                if ($result['count'] > 0) {
                    echo "   ✅ {$formatName}: '{$phoneFormat}' - Found {$result['count']} user(s)\n";
                } else {
                    echo "   ❌ {$formatName}: '{$phoneFormat}' - Not found\n";
                }
            }
        }
    }
    
    echo "\n=== COMMON PHONE NUMBER ISSUES ===\n";
    echo "1. Extra spaces at beginning/end\n";
    echo "2. Different formats (255..., +255..., 0...)\n";
    echo "3. Missing or extra digits\n";
    echo "4. Special characters\n";
    
    echo "\n=== SOLUTION ===\n";
    echo "Use the exact format: 255758503378\n";
    echo "Copy and paste to avoid typos\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
