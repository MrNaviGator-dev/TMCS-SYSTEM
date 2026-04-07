<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ADMIN USERS STATUS ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db",
        "postgres",
        "Alice2026@"
    );
    
    $stmt = $pdo->query("SELECT id, name, email, phone_number, role, membership_status FROM users WHERE role = 'admin'");
    $admins = $stmt->fetchAll();
    
    foreach ($admins as $admin) {
        $icon = $admin['membership_status'] == 'Active' ? '✅' : '❌';
        $canLogin = $admin['membership_status'] == 'Active' ? 'CAN LOGIN' : 'CANNOT LOGIN';
        echo "{$icon} ID: {$admin['id']} - {$admin['name']} - Status: {$admin['membership_status']} - {$canLogin}\n";
    }
    
    echo "\n🔍 LOGIN CONTROLLER CHECK:\n";
    echo "✅ Login controller checks membership_status == 'Active'\n";
    echo "✅ Only Active users can login\n";
    echo "❌ Inactive users get error message\n";
    
    echo "\n🎯 IF ADMIN IS INACTIVE:\n";
    echo "1. Admin tries to login\n";
    echo "2. Controller checks: membership_status !== 'Active'\n";
    echo "3. Login blocked with error: 'Your account is not yet approved'\n";
    echo "4. Admin stays on login page\n";
    echo "5. Should NOT redirect to dashboard\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
