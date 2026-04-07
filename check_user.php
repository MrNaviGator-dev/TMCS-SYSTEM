<?php
// Direct database query to check user status
echo "Checking user approval status...\n";

$pdo = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db", "postgres", "Alice2026@");

$stmt = $pdo->query("SELECT id, name, email, role, membership_status FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "User: {$user['name']} ({$user['email']})\n";
    echo "Role: {$user['role']}\n";
    echo "Status: {$user['membership_status']}\n\n";
}

if (count($users) > 0) {
    // Update to active admin
    $user = $users[0];
    echo "Updating {$user['email']} to active admin...\n";
    
    $pdo->prepare("UPDATE users SET membership_status = 'active', role = 'admin' WHERE id = ?")->execute([$user['id']]);
    echo "Updated successfully!\n";
}
