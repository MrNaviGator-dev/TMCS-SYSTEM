<?php
// Check all databases in PostgreSQL
try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=postgres",
        "postgres",
        "1234"
    );
    
    echo "=== AVAILABLE DATABASES ===\n\n";
    
    // List all databases
    $stmt = $pdo->query("SELECT datname FROM pg_database WHERE datistemplate = false");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($databases as $db) {
        echo "- {$db}\n";
    }
    
    echo "\n=== TESTING CONNECTIONS ===\n\n";
    
    // Test each database for users table
    foreach ($databases as $db) {
        try {
            $testPdo = new PDO(
                "pgsql:host=127.0.0.1;port=5432;dbname={$db}",
                "postgres",
                "1234"
            );
            
            $stmt = $testPdo->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_name = 'users'");
            $result = $stmt->fetch();
            
            if ($result['count'] > 0) {
                echo "✅ Database '{$db}' has 'users' table\n";
                
                $userStmt = $testPdo->query("SELECT COUNT(*) as count FROM users");
                $userCount = $userStmt->fetch();
                echo "   Users count: {$userCount['count']}\n";
            }
            
        } catch (PDOException $e) {
            echo "❌ Cannot connect to '{$db}': " . $e->getMessage() . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
