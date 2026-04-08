<?php
// Create the missing accounts sequence
try {
    $pdo = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db", "postgres", "Alice2026@");
    
    echo "Creating accounts_id_seq sequence...\n";
    
    // Create sequence
    $pdo->exec("CREATE SEQUENCE IF NOT EXISTS accounts_id_seq START 1");
    echo "Sequence created successfully\n";
    
    // Set default value for id column
    $pdo->exec("ALTER TABLE accounts ALTER COLUMN id SET DEFAULT nextval('accounts_id_seq')");
    echo "Default value set for id column\n";
    
    // Set ownership
    $pdo->exec("ALTER SEQUENCE accounts_id_seq OWNER TO postgres");
    echo "Ownership set\n";
    
    // Test the sequence
    $testQuery = $pdo->query("SELECT nextval('accounts_id_seq') as next_id");
    $nextId = $testQuery->fetchColumn();
    echo "Test sequence value: $nextId\n";
    
    echo "Accounts sequence setup completed successfully!\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
