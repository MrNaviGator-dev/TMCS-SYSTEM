<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK ID SEQUENCE ===\n\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Check current sequence status
    echo "1. Current users table structure:\n";
    $stmt = $pdo->query("
        SELECT column_name, data_type, column_default 
        FROM information_schema.columns 
        WHERE table_name = 'users' AND column_name = 'id'
    ");
    $result = $stmt->fetch();
    
    if ($result) {
        echo "   ID Column: {$result['column_name']}\n";
        echo "   Data Type: {$result['data_type']}\n";
        echo "   Default: {$result['column_default']}\n";
    }
    
    echo "\n2. Current sequence status:\n";
    $seqStmt = $pdo->query("
        SELECT sequence_name, last_value, start_value, increment_by 
        FROM information_schema.sequences 
        WHERE sequence_name LIKE '%users_id_seq%'
    ");
    $sequences = $seqStmt->fetchAll();
    
    if (count($sequences) > 0) {
        foreach ($sequences as $seq) {
            echo "   Sequence: {$seq['sequence_name']}\n";
            echo "   Last Value: {$seq['last_value']}\n";
            echo "   Start Value: {$seq['start_value']}\n";
            echo "   Increment: {$seq['increment_by']}\n";
        }
    } else {
        echo "   ❌ No sequence found\n";
    }
    
    echo "\n3. Fixing sequence...\n";
    
    // Reset sequence to start from 1
    $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH 1");
    echo "   ✅ Sequence reset to start from 1\n";
    
    // Check if sequence is properly set
    $checkStmt = $pdo->query("SELECT nextval('users_id_seq') as next_id");
    $nextId = $checkStmt->fetch();
    echo "   Next ID will be: {$nextId['next_id']}\n";
    
    // Reset it back since we just consumed one
    $pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH 1");
    echo "   ✅ Sequence properly reset\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
