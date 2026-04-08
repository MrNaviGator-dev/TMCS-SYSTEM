<?php
// Check database structure for accounts table
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "<h1>Accounts Table Structure</h1>";

try {
    // Get table structure
    $columns = DB::select("SELECT column_name, data_type, is_nullable FROM information_schema.columns WHERE table_name = 'accounts' AND table_schema = 'public' ORDER BY ordinal_position");
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Column Name</th><th>Data Type</th><th>Nullable</th></tr>";
    
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>{$column->column_name}</td>";
        echo "<td>{$column->data_type}</td>";
        echo "<td>{$column->is_nullable}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
