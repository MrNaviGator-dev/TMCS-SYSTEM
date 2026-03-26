<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get unique status values from users table
$users = \App\Models\User::distinct()->pluck('status');
$statuses = $users->toArray();

echo "User Status Options in Database:\n";
echo "===============================\n";

foreach ($statuses as $status) {
    echo "- " . $status . "\n";
}

echo "\nTotal unique statuses: " . count($statuses) . "\n";

// Also check some sample users
echo "\nSample Users:\n";
echo "=============\n";

$sampleUsers = \App\Models\User::take(5)->get(['id', 'name', 'email', 'status', 'role']);

foreach ($sampleUsers as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Status: {$user->status} | Role: {$user->role}\n";
}
