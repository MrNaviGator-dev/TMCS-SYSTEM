<?php
// Create tmcs_system database
try {
    // Connect to default postgres database
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=postgres",
        "postgres",
        "Alice2026@"
    );
    
    echo "✅ Connected to PostgreSQL\n";
    
    // Create tmcs_system database
    $pdo->exec("CREATE DATABASE tmcs_system");
    echo "✅ Database 'tmcs_system' created successfully!\n";
    
    // Test connection to new database
    $newPdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    echo "✅ Connected to tmcs_system database!\n";
    
    // Run migrations
    echo "\n🔄 Running migrations...\n";
    passthru("php artisan migrate --force");
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'already exists') !== false) {
        echo "✅ Database already exists\n";
        
        // Test connection
        try {
            $testPdo = new PDO(
                "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
                "postgres",
                "Alice2026@"
            );
            echo "✅ Connected to existing database\n";
            
            // Check if users table exists
            $stmt = $testPdo->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_name = 'users'");
            $result = $stmt->fetch();
            
            if ($result['count'] == 0) {
                echo "❌ Users table missing. Running migrations...\n";
                passthru("php artisan migrate --force");
            } else {
                echo "✅ Users table exists\n";
            }
            
        } catch (PDOException $e2) {
            echo "❌ Cannot connect to existing database: " . $e2->getMessage() . "\n";
        }
    } else {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}
?>
