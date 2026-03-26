<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DATABASE CONNECTION INFO ===\n\n";

// Show .env database settings
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    echo "📄 .env Database Settings:\n";
    echo "========================\n";
    
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        if (strpos($line, 'DB_') === 0) {
            echo $line . "\n";
        }
    }
}

echo "\n🗄️ Database Connection Details:\n";
echo "=============================\n";
echo "Database Engine: PostgreSQL\n";
echo "Database Name: tmcs_system\n";
echo "Table: users\n";
echo "Host: 127.0.0.1\n";
echo "Port: 5432\n";

echo "\n📋 Users Table Structure:\n";
echo "========================\n";

try {
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=tmcs_system",
        "postgres",
        "Alice2026@"
    );
    
    // Get table structure
    $stmt = $pdo->query("
        SELECT column_name, data_type, is_nullable, column_default
        FROM information_schema.columns 
        WHERE table_name = 'users' AND table_schema = 'public'
        ORDER BY ordinal_position
    ");
    
    $columns = $stmt->fetchAll();
    
    foreach ($columns as $column) {
        echo "📝 {$column['column_name']}: {$column['data_type']}";
        echo ($column['is_nullable'] == 'NO' ? ' (NOT NULL)' : ' (NULL)');
        if ($column['column_default']) {
            echo " DEFAULT: {$column['column_default']}";
        }
        echo "\n";
    }
    
    echo "\n📊 Current Data:\n";
    echo "================\n";
    
    $dataStmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $dataStmt->fetch();
    echo "Total Users: {$count['count']}\n";
    
    echo "\n🔍 Sample Query Used:\n";
    echo "====================\n";
    echo "SELECT * FROM users WHERE phone_number = '255758503378'\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
