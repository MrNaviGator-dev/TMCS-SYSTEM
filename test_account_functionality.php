<!DOCTYPE html>
<html>
<head>
    <title>Test Account Functionality</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        button { padding: 10px 15px; margin: 5px; }
    </style>
</head>
<body>
    <h1>Payment Accounts Functionality Test</h1>
    
    <div class="test-section">
        <h2>1. Database Check</h2>
        <?php
        require_once 'vendor/autoload.php';
        $app = require_once 'bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        try {
            $accounts = \App\Models\Account::all();
            echo "<p class='success'>Database connection successful. Found " . $accounts->count() . " accounts.</p>";
            
            if ($accounts->count() > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Account Name</th><th>Type</th><th>Account Number</th><th>Network/Bank</th><th>Status</th></tr>";
                foreach ($accounts as $account) {
                    echo "<tr>";
                    echo "<td>{$account->id}</td>";
                    echo "<td>" . ($account->account_name ?: '<span class="error">MISSING</span>') . "</td>";
                    echo "<td>{$account->account_type}</td>";
                    echo "<td>{$account->account_number}</td>";
                    echo "<td>" . ($account->network_bank ?: '<span class="info">N/A</span>') . "</td>";
                    echo "<td>{$account->status}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (Exception $e) {
            echo "<p class='error'>Database error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
    <div class="test-section">
        <h2>2. API Endpoint Test</h2>
        <button onclick="testAPI()">Test /admin/accounts API</button>
        <div id="apiResult"></div>
    </div>
    
    <div class="test-section">
        <h2>3. Test Instructions</h2>
        <h3>To test the issues:</h3>
        <ol>
            <li><strong>Test Edit Account:</strong>
                <ul>
                    <li>Go to admin dashboard</li>
                    <li>Navigate to Payment Accounts section</li>
                    <li>Click the edit (pencil) icon on any account</li>
                    <li>Change the account type from Mobile to Bank or vice versa</li>
                    <li>Verify that the Network/Bank dropdown updates with correct options</li>
                    <li>Verify that the previously selected Network/Bank value is preserved</li>
                    <li>Save the changes and confirm they are saved</li>
                </ul>
            </li>
            <li><strong>Test Add Account:</strong>
                <ul>
                    <li>Click "Add New Account" button</li>
                    <li>Fill in all fields including Account Name</li>
                    <li>Select account type and verify Network/Bank field appears</li>
                    <li>Select a Network/Bank option</li>
                    <li>Save the account</li>
                    <li>Verify the new account appears in the table with correct Account Name</li>
                </ul>
            </li>
        </ol>
        
        <h3>Expected Results:</h3>
        <ul>
            <li class="success">Edit form preserves Network/Bank value when changing account type</li>
            <li class="success">Add form shows Account Name in the table after saving</li>
            <li class="success">Network/Bank field dynamically shows correct options</li>
            <li class="success">All form data is properly saved to database</li>
        </ul>
    </div>
    
    <script>
        function testAPI() {
            const resultDiv = document.getElementById('apiResult');
            resultDiv.innerHTML = '<p class="info">Testing API...</p>';
            
            fetch('/admin/accounts')
                .then(response => {
                    resultDiv.innerHTML += `<p>Response status: ${response.status}</p>`;
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        resultDiv.innerHTML += `<p class="success">API Success! Found ${data.all_accounts.length} accounts.</p>`;
                        
                        // Check if account names are present
                        let missingNames = 0;
                        data.all_accounts.forEach(account => {
                            if (!account.account_name) missingNames++;
                        });
                        
                        if (missingNames > 0) {
                            resultDiv.innerHTML += `<p class="error">Warning: ${missingNames} accounts are missing account names!</p>`;
                        } else {
                            resultDiv.innerHTML += `<p class="success">All accounts have account names!</p>`;
                        }
                        
                        // Check network_bank field
                        let withNetworkBank = 0;
                        data.all_accounts.forEach(account => {
                            if (account.network_bank) withNetworkBank++;
                        });
                        
                        resultDiv.innerHTML += `<p class="info">${withNetworkBank} accounts have network/bank information.</p>`;
                    } else {
                        resultDiv.innerHTML += `<p class="error">API Error: ${data.message}</p>`;
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML += `<p class="error">API Error: ${error.message}</p>`;
                });
        }
    </script>
</body>
</html>
