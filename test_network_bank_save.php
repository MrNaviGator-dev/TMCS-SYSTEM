<!DOCTYPE html>
<html>
<head>
    <title>Test Network Bank Save</title>
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
        .form-group { margin: 10px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 5px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Test Network Bank Field Saving</h1>
    
    <div class="test-section">
        <h2>Current Database State</h2>
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
                echo "<tr>";
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
        } catch (Exception $e) {
            echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
    <div class="test-section">
        <h2>Test Account Creation</h2>
        <form id="testAccountForm">
            <div class="form-group">
                <label>Account Type:</label>
                <select name="account_type" required>
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
            
            <button type="submit">Test Create Account</button>
        </form>
        
        <div id="testResult"></div>
    </div>
    
    <script>
        // Handle account type change
        document.querySelector('select[name="account_type"]').addEventListener('change', function() {
            const accountType = this.value;
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
        });
        
        // Handle form submission
        document.getElementById('testAccountForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultDiv = document.getElementById('testResult');
            
            resultDiv.innerHTML = '<p class="info">Submitting test account...</p>';
            
            // Log form data
            console.log('Form data being submitted:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            fetch('/admin/accounts', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = `
                        <p class="success">Account created successfully!</p>
                        <p><strong>Account ID:</strong> ${data.account.id}</p>
                        <p><strong>Account Name:</strong> ${data.account.account_name}</p>
                        <p><strong>Account Type:</strong> ${data.account.account_type}</p>
                        <p><strong>Network/Bank:</strong> ${data.account.network_bank || 'NULL'}</p>
                        <p><strong>Account Number:</strong> ${data.account.account_number}</p>
                        <p><strong>Status:</strong> ${data.account.status}</p>
                        <button onclick="location.reload()">Refresh Database View</button>
                    `;
                } else {
                    resultDiv.innerHTML = `<p class="error">Error: ${data.message}</p>`;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `<p class="error">Network Error: ${error.message}</p>`;
            });
        });
    </script>
</body>
</html>
