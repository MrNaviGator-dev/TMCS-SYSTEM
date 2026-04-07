<?php
// Check user status and fix admin approval issue
echo "Checking user status and admin approval...\n\n";

try {
    // Connect to database
    $pdo = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db", "postgres", "Alice2026@");
    
    // Check all users
    $stmt = $pdo->query("SELECT id, name, email, role, membership_status, created_at FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($users) . " user(s):\n\n";
    
    foreach ($users as $user) {
        echo "User ID: {$user['id']}\n";
        echo "Name: {$user['name']}\n";
        echo "Email: {$user['email']}\n";
        echo "Role: {$user['role']}\n";
        echo "Membership Status: {$user['membership_status']}\n";
        echo "Created: {$user['created_at']}\n";
        echo "-----------------------------------\n";
    }
    
    // Fix admin approval issue
    if (count($users) > 0) {
        $user = $users[0]; // Get first user
        
        echo "\nFixing admin approval for user: {$user['email']}\n";
        
        // Update user to active status and admin role if needed
        $updateStmt = $pdo->prepare("
            UPDATE users 
            SET membership_status = 'active', 
                role = 'admin' 
            WHERE id = ?
        ");
        $updateStmt->execute([$user['id']]);
        
        echo "Updated user status to 'active' and role to 'admin'\n";
        
        // Verify the update
        $verifyStmt = $pdo->prepare("SELECT role, membership_status FROM users WHERE id = ?");
        $verifyStmt->execute([$user['id']]);
        $updatedUser = $verifyStmt->fetch(PDO::FETCH_ASSOC);
        
        echo "Verification - Role: {$updatedUser['role']}, Status: {$updatedUser['membership_status']}\n";
    }
    
    echo "\nTry logging in now with your credentials!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
