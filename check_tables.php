<?php
// Check database tables
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "🔍 Checking PostgreSQL Database Tables...\n\n";

try {
    // Get all tables
    $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    
    echo "📊 Total Tables Found: " . count($tables) . "\n\n";
    
    foreach ($tables as $table) {
        $tableName = $table->table_name;
        
        // Get row count
        $count = DB::table($tableName)->count();
        
        echo "📋 Table: {$tableName}\n";
        echo "   Rows: {$count}\n";
        
        // Get column info for some key tables
        if (in_array($tableName, ['users', 'payments', 'announcements', 'sessions'])) {
            $columns = DB::select("
                SELECT column_name, data_type 
                FROM information_schema.columns 
                WHERE table_name = '{$tableName}' AND table_schema = 'public'
                ORDER BY ordinal_position
            ");
            
            echo "   Columns: " . count($columns) . "\n";
            foreach ($columns as $column) {
                echo "     - {$column->column_name} ({$column->data_type})\n";
            }
        }
        echo "\n";
    }
    
    echo "✅ Database check completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error checking tables: " . $e->getMessage() . "\n";
}
