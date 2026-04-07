<?php
// Show current .env database settings
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    echo "=== CURRENT .env SETTINGS ===\n\n";
    
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        if (strpos($line, 'DB_') === 0) {
            echo $line . "\n";
        }
    }
} else {
    echo "❌ .env file not found\n";
}
?>
