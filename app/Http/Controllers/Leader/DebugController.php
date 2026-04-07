<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function checkUsers()
    {
        // Get all users and their membership status
        $allUsers = User::all();
        
        echo "<h2>User Database Debug</h2>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th>";
        echo "<th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Membership Status</th>";
        echo "<th>Created At</th>";
        echo "</tr>";
        
        foreach ($allUsers as $user) {
            $status = $user->membership_status ?? 'NULL';
            $statusColor = ($status == 'Pending') ? '#ffcccc' : (($status == 'Active') ? '#ccffcc' : '#ffffff');
            
            echo "<tr>";
            echo "<td>" . $user->id . "</td>";
            echo "<td>" . htmlspecialchars($user->name) . "</td>";
            echo "<td>" . htmlspecialchars($user->email) . "</td>";
            echo "<td style='background: " . $statusColor . "; font-weight: bold;'>" . $status . "</td>";
            echo "<td>" . $user->created_at . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Count by status
        echo "<h3>Status Counts:</h3>";
        $pendingCount = User::where('membership_status', 'Pending')->count();
        $activeCount = User::where('membership_status', 'Active')->count();
        $premiumCount = User::where('membership_status', 'Premium')->count();
        $nullCount = User::whereNull('membership_status')->count();
        
        echo "<ul>";
        echo "<li><strong>Pending:</strong> " . $pendingCount . "</li>";
        echo "<li><strong>Active:</strong> " . $activeCount . "</li>";
        echo "<li><strong>Premium:</strong> " . $premiumCount . "</li>";
        echo "<li><strong>NULL:</strong> " . $nullCount . "</li>";
        echo "</ul>";
        
        // Show the actual query being used
        echo "<h3>Query Test:</h3>";
        $pendingUsers = User::where('membership_status', 'Pending')->get();
        echo "<p>Query: <code>User::where('membership_status', 'Pending')->count()</code></p>";
        echo "<p>Result: " . $pendingUsers->count() . " users found</p>";
        
        if ($pendingUsers->isNotEmpty()) {
            echo "<h4>Pending Users Found:</h4>";
            foreach ($pendingUsers as $user) {
                echo "<p>ID: " . $user->id . ", Name: " . $user->name . ", Status: '" . $user->membership_status . "'</p>";
            }
        }
    }
}
