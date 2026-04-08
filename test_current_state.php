<!DOCTYPE html>
<html>
<head>
    <title>Current State Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .step { background: #f9f9f9; padding: 10px; margin: 5px 0; border-left: 4px solid #007bff; }
    </style>
</head>
<body>
    <h1>Network Bank Field Fix - Current State</h1>
    
    <div class="section">
        <h2>Database Current State</h2>
        <?php
        require_once 'vendor/autoload.php';
        $app = require_once 'bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        try {
            $accounts = \App\Models\Account::orderBy('created_at', 'desc')->get();
            echo "<table>";
            echo "<tr><th>ID</th><th>Account Name</th><th>Type</th><th>Account Number</th><th>Network/Bank</th><th>Status</th><th>Created</th></tr>";
            foreach ($accounts as $account) {
                $networkBank = $account->network_bank ?: '<span class="error">NULL</span>';
                $rowClass = $account->network_bank ? '' : 'style="background-color: #ffe6e6;"';
                echo "<tr $rowClass>";
                echo "<td>{$account->id}</td>";
                echo "<td>{$account->account_name}</td>";
                echo "<td>{$account->account_type}</td>";
                echo "<td>{$account->account_number}</td>";
                echo "<td>{$networkBank}</td>";
                echo "<td>{$account->status}</td>";
                echo "<td>{$account->created_at}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            $nullCount = \App\Models\Account::whereNull('network_bank')->count();
            $totalCount = \App\Models\Account::count();
            echo "<p><strong>Summary:</strong> {$nullCount} out of {$totalCount} accounts have NULL network_bank values</p>";
            
        } catch (Exception $e) {
            echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
    <div class="section">
        <h2>What Has Been Fixed</h2>
        <div class="step">
            <h3>1. Form Submission Fix</h3>
            <p>Updated the JavaScript form submission to always include the network_bank field value, even if empty.</p>
            <p>Added robust checking to ensure the networkBank element exists before accessing its value.</p>
        </div>
        
        <div class="step">
            <h3>2. Validation Fix</h3>
            <p>Changed network_bank validation from 'nullable' to 'required_if:account_type,mobile|required_if:account_type,bank'.</p>
            <p>This means network_bank is now mandatory when account_type is mobile or bank.</p>
        </div>
        
        <div class="step">
            <h3>3. Debug Logging</h3>
            <p>Added comprehensive logging in AccountController to track incoming request data.</p>
            <p>Added console debugging in frontend to verify form data being submitted.</p>
        </div>
        
        <div class="step">
            <h3>4. Error Messages</h3>
            <p>Enhanced error messages to provide more detailed feedback when account creation fails.</p>
        </div>
    </div>
    
    <div class="section">
        <h2>Test Instructions</h2>
        <div class="step">
            <h3>Step 1: Test the Admin Dashboard</h3>
            <ol>
                <li>Go to the admin dashboard</li>
                <li>Click on "Add New Account" button</li>
                <li>Select "Mobile" as account type</li>
                <li>Select a mobile network (e.g., "M-Pesa")</li>
                <li>Fill in account name and number</li>
                <li>Submit the form</li>
                <li>Check browser console for debug messages</li>
            </ol>
        </div>
        
        <div class="step">
            <h3>Step 2: Check Results</h3>
            <ol>
                <li>Refresh this page to see the updated database</li>
                <li>Check if the new account has a network_bank value</li>
                <li>If still NULL, check the Laravel logs for debug information</li>
            </ol>
        </div>
        
        <div class="step">
            <h3>Step 3: Check Logs</h3>
            <p>Use the debug route to check recent logs:</p>
            <p><a href="/debug/logs" target="_blank">View Laravel Logs</a></p>
            <p>Look for "=== ACCOUNT STORE DEBUG ===" entries to see what data is being received.</p>
        </div>
    </div>
    
    <div class="section">
        <h2>Expected Debug Output</h2>
        <p>When you submit the form, you should see in the browser console:</p>
        <pre>
=== FORM SUBMISSION DEBUG ===
account_type: "mobile"
account_name: "Test Account"
account_number: "123456789"
network_bank: "M-Pesa"
status: "active"
networkBank element exists: true
networkBank element value: M-Pesa
============================
        </pre>
        
        <p>And in Laravel logs, you should see:</p>
        <pre>
[2026-04-08 XX:XX:XX] local.INFO: === ACCOUNT STORE DEBUG ===
[2026-04-08 XX:XX:XX] local.INFO: All request data: {"account_type":"mobile","account_name":"Test Account","account_number":"123456789","network_bank":"M-Pesa","status":"active"}
[2026-04-08 XX:XX:XX] local.INFO: network_bank specifically: M-Pesa
[2026-04-08 XX:XX:XX] local.INFO: ==========================
        </pre>
    </div>
    
    <div class="section">
        <h2>If Still Not Working</h2>
        <p>If the network_bank field is still NULL after testing, possible causes:</p>
        <ul>
            <li><strong>Browser Cache:</strong> Clear browser cache and reload the admin dashboard</li>
            <li><strong>Laravel Cache:</strong> Run <code>php artisan cache:clear</code> and <code>php artisan config:clear</code></li>
            <li><strong>JavaScript Error:</strong> Check browser console for JavaScript errors</li>
            <li><strong>Validation Error:</strong> Check Laravel logs for validation failures</li>
        </ul>
    </div>
    
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="location.reload()">Refresh This Page</button>
        <button onclick="window.open('/admin/dashboard', '_blank')">Open Admin Dashboard</button>
    </div>
</body>
</html>
