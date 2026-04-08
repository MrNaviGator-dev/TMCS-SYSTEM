<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h1>Account Records Test</h1>";

try {
    $accounts = \App\Models\Account::all();
    
    if ($accounts->count() > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>ID</th><th>Account Name</th><th>Type</th><th>Account Number</th><th>Network/Bank</th><th>Status</th></tr>";
        
        foreach ($accounts as $account) {
            echo "<tr>";
            echo "<td>{$account->id}</td>";
            echo "<td>{$account->account_name}</td>";
            echo "<td>{$account->account_type}</td>";
            echo "<td>{$account->account_number}</td>";
            echo "<td>" . ($account->network_bank ?? 'N/A') . "</td>";
            echo "<td>{$account->status}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No accounts found in database.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
