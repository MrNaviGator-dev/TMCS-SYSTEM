<?php
// Test account creation directly
use Illuminate\Support\Facades\DB;

echo "Testing account creation...\n";

try {
    // Test inserting a record
    $pdo = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db", "postgres", "Alice2026@");
    
    $testData = [
        'account_type' => 'mobile',
        'account_number' => 'TEST123456',
        'account_name' => 'Test Mobile Account',
        'status' => 'active'
    ];
    
    // Check if sequence exists
    $sequenceCheck = $pdo->query("SELECT nextval('accounts_id_seq') as next_id");
    $nextId = $sequenceCheck->fetchColumn();
    echo "Next sequence ID: $nextId\n";
    
    // Insert test account
    $sql = "INSERT INTO accounts (account_type, account_number, account_name, status, created_at) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$testData['account_type'], $testData['account_number'], $testData['account_name'], $testData['status']])) {
        $id = $pdo->lastInsertId('accounts_id_seq');
        echo "Test account created with ID: $id\n";
        
        // Verify the record
        $verifyStmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
        $verifyStmt->execute([$id]);
        $account = $verifyStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($account) {
            echo "Account verified: " . json_encode($account, JSON_PRETTY_PRINT) . "\n";
        } else {
            echo "ERROR: Account not found after creation!\n";
        }
        
        // Clean up
        $deleteStmt = $pdo->prepare("DELETE FROM accounts WHERE id = ?");
        $deleteStmt->execute([$id]);
        echo "Test account cleaned up\n";
        
    } else {
        echo "ERROR: Failed to create test account\n";
        print_r($stmt->errorInfo());
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
