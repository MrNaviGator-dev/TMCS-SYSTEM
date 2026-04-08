<?php
// Check current accounts and their network_bank values
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Account;

echo "<h1>Current Accounts with Network/Bank Fields</h1>";

try {
    $accounts = Account::all();
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>ID</th><th>Type</th><th>Name</th><th>Network/Bank</th><th>Number</th><th>Status</th></tr>";
    
    foreach ($accounts as $account) {
        echo "<tr>";
        echo "<td>{$account->id}</td>";
        echo "<td>{$account->account_type}</td>";
        echo "<td>{$account->account_name}</td>";
        echo "<td>" . ($account->network_bank ?? 'NULL/EMPTY') . "</td>";
        echo "<td>{$account->account_number}</td>";
        echo "<td>{$account->status}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Test creating a new account with network_bank
    echo "<h2>Test Creating Account with Network/Bank</h2>";
    
    $testAccount = new Account();
    $testAccount->account_type = 'mobile';
    $testAccount->account_number = 'TEST123456';
    $testAccount->account_name = 'Test Mobile Account';
    $testAccount->network_bank = 'M-Pesa';
    $testAccount->status = 'active';
    
    if ($testAccount->save()) {
        echo "<p style='color: green;'>Test account created successfully!</p>";
        echo "<p>Created account ID: {$testAccount->id}</p>";
        echo "<p>Network/Bank: {$testAccount->network_bank}</p>";
        
        // Clean up - delete the test account
        $testAccount->delete();
        echo "<p style='color: blue;'>Test account deleted.</p>";
    } else {
        echo "<p style='color: red;'>Failed to create test account.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
