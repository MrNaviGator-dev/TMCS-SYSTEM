<?php
// Test to see what fields are returned by Account model
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Account;

echo "<h1>Account Fields Test</h1>";

try {
    // Get all accounts and show their fields
    $accounts = Account::all();
    
    echo "<h2>Database Accounts:</h2>";
    
    if ($accounts->count() > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>ID</th><th>Type</th><th>Name</th><th>Network/Bank</th><th>Number</th><th>Status</th></tr>";
        
        foreach ($accounts as $account) {
            echo "<tr>";
            echo "<td>{$account->id}</td>";
            echo "<td>{$account->account_type}</td>";
            echo "<td>{$account->account_name}</td>";
            echo "<td>" . ($account->network_bank ?? 'NULL') . "</td>";
            echo "<td>{$account->account_number}</td>";
            echo "<td>{$account->status}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        echo "<h2>Raw Account Object Fields:</h2>";
        $firstAccount = $accounts->first();
        echo "<pre>";
        print_r($firstAccount->toArray());
        echo "</pre>";
        
    } else {
        echo "<p>No accounts found in database.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
