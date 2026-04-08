<?php
// Update existing accounts to have network_bank values for testing
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Account;

echo "<h1>Update Test Accounts with Network/Bank Values</h1>";

try {
    // Update account ID 4 (mobile) to have M-Pesa
    $account4 = Account::find(4);
    if ($account4) {
        $account4->network_bank = 'M-Pesa';
        $account4->save();
        echo "<p style='color: green;'>Updated Account 4 (Mobile): {$account4->account_name} -> Network: {$account4->network_bank}</p>";
    }
    
    // Update account ID 5 (bank) to have NMB Bank
    $account5 = Account::find(5);
    if ($account5) {
        $account5->network_bank = 'NMB';
        $account5->save();
        echo "<p style='color: green;'>Updated Account 5 (Bank): {$account5->account_name} -> Bank: {$account5->network_bank}</p>";
    }
    
    echo "<h2>Updated Accounts:</h2>";
    $accounts = Account::all();
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>ID</th><th>Type</th><th>Name</th><th>Network/Bank</th><th>Number</th><th>Status</th></tr>";
    
    foreach ($accounts as $account) {
        echo "<tr>";
        echo "<td>{$account->id}</td>";
        echo "<td>{$account->account_type}</td>";
        echo "<td>{$account->account_name}</td>";
        echo "<td><strong>" . ($account->network_bank ?? 'NULL/EMPTY') . "</strong></td>";
        echo "<td>{$account->account_number}</td>";
        echo "<td>{$account->status}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
