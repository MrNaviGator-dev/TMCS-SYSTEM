<?php

// Add sample accounts to database
$host = '127.0.0.1';
$port = '5432';
$dbname = 'tmcs_db';
$user = 'postgres';
$password = '1234';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully!\n";
    
    // Clear existing accounts first
    $pdo->exec("DELETE FROM accounts");
    echo "Cleared existing accounts\n";
    
    // Insert sample mobile money accounts
    $stmt = $pdo->prepare("INSERT INTO accounts (account_type, sender_name, account_name, account_number, branch_name, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        'mobile_money',
        'John Doe',
        'M-Pesa Main',
        '255712345678',
        null,
        'active',
        date('Y-m-d H:i:s')
    ]);
    
    $stmt->execute([
        'mobile_money',
        'Jane Smith',
        'Tigo Pesa',
        '255876543210',
        null,
        'active',
        date('Y-m-d H:i:s')
    ]);
    
    // Insert sample bank accounts
    $stmt->execute([
        'bank',
        'TMCS Organization',
        'CRDB Main Account',
        '0151234567890',
        'Kigoma Branch',
        'active',
        date('Y-m-d H:i:s')
    ]);
    
    $stmt->execute([
        'bank',
        'TMCS Organization',
        'NBC Savings',
        '0150987654321',
        'Dar es Salaam Branch',
        'inactive',
        date('Y-m-d H:i:s')
    ]);
    
    echo "Sample accounts added successfully!\n";
    
    // Query all accounts to verify
    $stmt2 = $pdo->query("SELECT * FROM accounts ORDER BY created_at DESC");
    
    echo "\nAll accounts in database:\n";
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: " . $row['id'] . 
             ", Type: " . $row['account_type'] . 
             ", Sender: " . $row['sender_name'] . 
             ", Name: " . $row['account_name'] . 
             ", Number: " . $row['account_number'] . 
             ", Branch: " . ($row['branch_name'] ?: 'N/A') . 
             ", Status: " . $row['status'] . 
             ", Created: " . $row['created_at'] . "\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
