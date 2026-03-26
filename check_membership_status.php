<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get unique membership_status values from users table
$statuses = \App\Models\User::distinct()->pluck('membership_status')->toArray();

echo "Membership Status Options in Database:\n";
echo "=====================================\n";

foreach ($statuses as $status) {
    echo "- " . $status . "\n";
}

echo "\nTotal unique statuses: " . count($statuses) . "\n";

// Count users by status
echo "\nUser Count by Status:\n";
echo "======================\n";

foreach ($statuses as $status) {
    $count = \App\Models\User::where('membership_status', $status)->count();
    echo "- {$status}: {$count} users\n";
}
