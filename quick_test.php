<?php
// Quick test of current setup
echo "=== QUICK SYSTEM CHECK ===\n\n";

// Check if we can read .env
if (file_exists('.env')) {
    echo "✅ .env file exists\n";
    $envContent = file_get_contents('.env');
    
    if (strpos($envContent, 'DB_CONNECTION=pgsql') !== false) {
        echo "✅ PostgreSQL connection configured\n";
    }
    
    if (strpos($envContent, 'DB_PASSWORD=1234') !== false) {
        echo "✅ Password set to 1234\n";
    }
} else {
    echo "❌ .env file missing\n";
}

// Check if migrations exist
if (file_exists('database/migrations')) {
    $migrations = glob('database/migrations/*.php');
    echo "✅ Migration files: " . count($migrations) . "\n";
}

// Check if routes exist
if (file_exists('routes/web.php')) {
    echo "✅ Routes file exists\n";
}

echo "\n=== NEXT STEPS ===\n";
echo "1. Please check PostgreSQL password in pgAdmin\n";
echo "2. Confirm database name\n";
echo "3. Test registration manually\n";
?>
