<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TMCS USERS DATABASE ===\n\n";

$users = App\Models\User::all();

if ($users->isEmpty()) {
    echo "No users found in database!\n";
} else {
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Phone: {$user->phone_number}\n";
        echo "Role: {$user->role}\n";
        echo "Registration: {$user->registration_date}\n";
        echo "------------------------\n";
    }
}

echo "\nTotal Users: " . $users->count() . "\n";
?>
