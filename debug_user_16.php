<?php
require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get database connection
$db = Illuminate\Support\Facades\DB::connection();

echo "<h2>User ID 16 Debug Information</h2>";

try {
    // Get user 16's details
    $user = $db->table('users')->where('id', 16)->first();
    
    if ($user) {
        echo "<h3>User Found</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        echo "<tr><td>ID</td><td>" . $user->id . "</td></tr>";
        echo "<tr><td>Name</td><td>" . $user->name . "</td></tr>";
        echo "<tr><td>Email</td><td>" . $user->email . "</td></tr>";
        echo "<tr><td>Role</td><td>" . $user->role . "</td></tr>";
        echo "<tr><td>Membership Status</td><td>" . $user->membership_status . "</td></tr>";
        echo "<tr><td>Email Verified At</td><td>" . ($user->email_verified_at ?? 'Not verified') . "</td></tr>";
        echo "<tr><td>Created At</td><td>" . $user->created_at . "</td></tr>";
        echo "<tr><td>Updated At</td><td>" . $user->updated_at . "</td></tr>";
        echo "</table>";
        
        // Check if user has any payment records
        $payments = $db->table('payments')->where('user_id', 16)->get();
        echo "<h3>Payment Records (" . $payments->count() . " found)</h3>";
        if ($payments->count() > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>Payment ID</th><th>Amount</th><th>Status</th><th>Date</th></tr>";
            foreach ($payments as $payment) {
                echo "<tr>";
                echo "<td>" . $payment->id . "</td>";
                echo "<td>" . $payment->amount . "</td>";
                echo "<td>" . $payment->status . "</td>";
                echo "<td>" . $payment->created_at . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No payment records found for this user.</p>";
        }
        
        // Check authentication requirements
        echo "<h3>Authentication Analysis</h3>";
        echo "<ul>";
        echo "<li><strong>Email Verified:</strong> " . ($user->email_verified_at ? "✅ Yes" : "❌ No") . "</li>";
        echo "<li><strong>Membership Status:</strong> " . $user->membership_status . "</li>";
        echo "<li><strong>Role:</strong> " . $user->role . "</li>";
        
        if ($user->membership_status === 'Pending') {
            echo "<li style='color: red;'><strong>Issue:</strong> User membership status is 'Pending' - this may prevent login</li>";
        }
        
        if (!$user->email_verified_at) {
            echo "<li style='color: red;'><strong>Issue:</strong> Email not verified - this may prevent login</li>";
        }
        
        echo "</ul>";
        
    } else {
        echo "<h3 style='color: red;'>User ID 16 NOT FOUND in database</h3>";
    }
    
    // Check all users to see the pattern
    echo "<h3>All Users Summary</h3>";
    $allUsers = $db->table('users')->select('id', 'name', 'email', 'role', 'membership_status', 'email_verified_at')->get();
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Email Verified</th></tr>";
    foreach ($allUsers as $u) {
        echo "<tr>";
        echo "<td>" . $u->id . "</td>";
        echo "<td>" . $u->name . "</td>";
        echo "<td>" . $u->email . "</td>";
        echo "<td>" . $u->role . "</td>";
        echo "<td>" . $u->membership_status . "</td>";
        echo "<td>" . ($u->email_verified_at ? "✅" : "❌") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>Error</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
