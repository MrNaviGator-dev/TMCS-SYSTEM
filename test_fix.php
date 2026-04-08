<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test creating an account with network_bank
try {
    $testData = [
        'account_type' => 'mobile',
        'account_name' => 'Test Fix Account',
        'account_number' => '999888777',
        'network_bank' => 'M-Pesa',
        'status' => 'active',
        'created_at' => now()
    ];
    
    echo "Creating test account with data:\n";
    print_r($testData);
    
    $account = \App\Models\Account::create($testData);
    
    echo "\n\nCreated account:\n";
    echo "ID: " . $account->id . "\n";
    echo "Account Name: " . $account->account_name . "\n";
    echo "Account Type: " . $account->account_type . "\n";
    echo "Account Number: " . $account->account_number . "\n";
    echo "Network Bank: " . ($account->network_bank ?: 'NULL') . "\n";
    echo "Status: " . $account->status . "\n";
    echo "Created At: " . $account->created_at . "\n";
    
    // Clean up - delete the test account
    $account->delete();
    echo "\nTest account deleted successfully.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
