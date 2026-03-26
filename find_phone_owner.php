<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FIND PHONE OWNER ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    $phoneNumber = '255758503378';
    echo "Searching for phone number: {$phoneNumber}\n\n";
    
    // Find user by phone number
    $stmt = $pdo->prepare("SELECT * FROM users WHERE phone_number = ?");
    $stmt->execute([$phoneNumber]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "✅ USER FOUND!\n";
        echo "================\n";
        echo "👤 Name: {$user['name']}\n";
        echo "📧 Email: {$user['email']}\n";
        echo "📱 Phone: {$user['phone_number']}\n";
        echo "🆔 ID: {$user['id']}\n";
        echo "🛡️ Role: {$user['role']}\n";
        echo "📅 Registration: {$user['registration_date']}\n";
        echo "🏠 Diocese: {$user['home_diocese']}\n";
        
        if ($user['profile_picture']) {
            echo "📸 Profile Picture: {$user['profile_picture']}\n";
        } else {
            echo "📸 Profile Picture: None\n";
        }
        
        echo "\n🔐 LOGIN DETAILS:\n";
        echo "Phone: {$user['phone_number']}\n";
        echo "Password: (Set during registration)\n";
        
    } else {
        echo "❌ User not found with phone number: {$phoneNumber}\n";
        
        // Try other formats
        echo "\nTrying other formats...\n";
        $formats = [
            '+255758503378',
            '0758503378',
            '758503378'
        ];
        
        foreach ($formats as $format) {
            $testStmt = $pdo->prepare("SELECT name, email FROM users WHERE phone_number = ?");
            $testStmt->execute([$format]);
            $testUser = $testStmt->fetch();
            
            if ($testUser) {
                echo "✅ Found with format '{$format}': {$testUser['name']} ({$testUser['email']})\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
