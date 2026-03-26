<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get users table structure
echo "Users Table Structure:\n";
echo "======================\n";

$columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');

foreach ($columns as $column) {
    echo "- " . $column . "\n";
}

echo "\nSample Users:\n";
echo "=============\n";

$sampleUsers = \App\Models\User::take(5)->get();

foreach ($sampleUsers as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: {$user->role}\n";
    echo "   All attributes: " . json_encode($user->getAttributes()) . "\n\n";
}
