<?php
// Simple database table check without Laravel facades
echo "🔍 Checking PostgreSQL Database Tables...\n\n";

try {
    // Connect directly to PostgreSQL
    $pdo = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=tmcs_db", "postgres", "Alice2026@");
    
    echo "✅ Connected to PostgreSQL successfully!\n\n";
    
    // Get all tables
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "📊 Total Tables Found: " . count($tables) . "\n\n";
    
    foreach ($tables as $table) {
        // Get row count
        $countStmt = $pdo->query("SELECT COUNT(*) FROM \"$table\"");
        $count = $countStmt->fetchColumn();
        
        echo "📋 Table: {$table}\n";
        echo "   Rows: {$count}\n";
        echo "\n";
    }
    
    echo "✅ Database check completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
