<!DOCTYPE html>
<html>
<head>
    <title>Debug Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-section { border: 1px solid #ccc; padding: 15px; margin: 10px 0; background: #f9f9f9; }
        .error { color: red; }
        .success { color: green; }
        .info { color: blue; }
        pre { background: #eee; padding: 10px; overflow-x: auto; }
        button { padding: 10px 15px; margin: 5px; }
        .form-group { margin: 10px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 5px; margin-bottom: 10px; width: 200px; }
    </style>
</head>
<body>
    <h1>Debug Form Submission - Network Bank Field</h1>
    
    <div class="debug-section">
        <h2>Step 1: Test Manual Form</h2>
        <form id="debugForm">
            <div class="form-group">
                <label>Account Type:</label>
                <select name="account_type" required onchange="handleAccountTypeChange()">
                    <option value="">Select Type</option>
                    <option value="mobile">Mobile</option>
                    <option value="bank">Bank</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Account Name:</label>
                <input type="text" name="account_name" required>
            </div>
            
            <div class="form-group">
                <label>Account Number:</label>
                <input type="text" name="account_number" required>
            </div>
            
            <div class="form-group" id="networkBankGroup" style="display: none;">
                <label id="networkBankLabel">Network/Bank:</label>
                <select name="network_bank" id="networkBankSelect">
                    <option value="">Select...</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Status:</label>
                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            
            <button type="submit">Test Submit</button>
            <button type="button" onclick="debugFormData()">Debug Form Data</button>
        </form>
        
        <div id="debugOutput"></div>
    </div>
    
    <div class="debug-section">
        <h2>Step 2: Current Database State</h2>
        <?php
        require_once 'vendor/autoload.php';
        $app = require_once 'bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        try {
            $accounts = \App\Models\Account::orderBy('created_at', 'desc')->limit(3)->get();
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Number</th><th>Network/Bank</th><th>Created</th></tr>";
            foreach ($accounts as $account) {
                $networkBank = $account->network_bank ?: '<span class="error">NULL</span>';
                echo "<tr>";
                echo "<td>{$account->id}</td>";
                echo "<td>{$account->account_name}</td>";
                echo "<td>{$account->account_type}</td>";
                echo "<td>{$account->account_number}</td>";
                echo "<td>{$networkBank}</td>";
                echo "<td>{$account->created_at}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } catch (Exception $e) {
            echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
    <div class="debug-section">
        <h2>Step 3: Check Laravel Logs</h2>
        <button onclick="checkLogs()">Check Recent Logs</button>
        <div id="logOutput"></div>
    </div>
    
    <script>
        function handleAccountTypeChange() {
            const accountType = document.querySelector('select[name="account_type"]').value;
            const networkBankGroup = document.getElementById('networkBankGroup');
            const networkBankLabel = document.getElementById('networkBankLabel');
            const networkBankSelect = document.getElementById('networkBankSelect');
            
            if (accountType === 'mobile') {
                networkBankGroup.style.display = 'block';
                networkBankLabel.textContent = 'Mobile Network';
                networkBankSelect.innerHTML = `
                    <option value="">Select Mobile Network...</option>
                    <option value="M-Pesa">M-Pesa</option>
                    <option value="Tigo Pesa">Tigo Pesa</option>
                    <option value="Airtel Money">Airtel Money</option>
                    <option value="Halopesa">Halopesa</option>
                `;
                networkBankSelect.required = true;
            } else if (accountType === 'bank') {
                networkBankGroup.style.display = 'block';
                networkBankLabel.textContent = 'Bank Name';
                networkBankSelect.innerHTML = `
                    <option value="">Select Bank...</option>
                    <option value="NMB">NMB Bank</option>
                    <option value="CRDB">CRDB Bank</option>
                    <option value="NBC">National Bank of Commerce</option>
                    <option value="KCB">KCB Bank Tanzania</option>
                `;
                networkBankSelect.required = true;
            } else {
                networkBankGroup.style.display = 'none';
                networkBankSelect.required = false;
            }
        }
        
        function debugFormData() {
            const form = document.getElementById('debugForm');
            const formData = new FormData(form);
            const output = document.getElementById('debugOutput');
            
            let html = '<h3>Form Data Debug:</h3>';
            html += '<pre>';
            for (let [key, value] of formData.entries()) {
                html += key + ': "' + value + '"\n';
            }
            html += '</pre>';
            
            // Check specific network_bank field
            const networkBankElement = document.getElementById('networkBankSelect');
            html += '<h3>Network Bank Field:</h3>';
            html += '<pre>';
            html += 'Element exists: ' + !!networkBankElement + '\n';
            html += 'Element value: "' + (networkBankElement ? networkBankElement.value : 'N/A') + '"\n';
            html += 'Element visible: ' + (networkBankElement ? networkBankElement.parentElement.style.display !== 'none' : 'N/A') + '\n';
            html += 'Element required: ' + (networkBankElement ? networkBankElement.required : 'N/A') + '\n';
            html += '</pre>';
            
            output.innerHTML = html;
        }
        
        document.getElementById('debugForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const output = document.getElementById('debugOutput');
            
            // Always include network_bank field value
            const networkBankValue = document.getElementById('networkBankSelect').value || '';
            formData.set('network_bank', networkBankValue);
            
            output.innerHTML = '<h3>Submitting Form...</h3>';
            
            fetch('/admin/accounts', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                output.innerHTML = `
                    <h3>Response:</h3>
                    <pre>${JSON.stringify(data, null, 2)}</pre>
                    <button onclick="location.reload()">Refresh Page</button>
                `;
            })
            .catch(error => {
                output.innerHTML = `<h3>Error:</h3><pre>${error.message}</pre>`;
            });
        });
        
        function checkLogs() {
            const output = document.getElementById('logOutput');
            output.innerHTML = '<p>Checking logs...</p>';
            
            fetch('/debug/logs')
                .then(response => response.text())
                .then(data => {
                    output.innerHTML = `
                        <h3>Recent Logs:</h3>
                        <pre>${data}</pre>
                    `;
                })
                .catch(error => {
                    output.innerHTML = `<p>Error checking logs: ${error.message}</p>`;
                });
        }
    </script>
</body>
</html>
