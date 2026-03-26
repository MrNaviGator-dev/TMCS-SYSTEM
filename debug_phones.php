<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check phone numbers in database
echo "=== DEBUG: Checking Phone Numbers in Database ===\n\n";

$users = App\Models\User::all();

echo "Total users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "User: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Phone Number: '" . $user->phone_number . "'\n";
    echo "Home Diocese: '" . $user->home_diocese . "'\n";
    echo "Role: " . $user->role . "\n";
    echo "Status: " . $user->status . "\n";
    echo "---\n";
}

echo "\n=== Users with phone numbers ===\n";
$usersWithPhones = App\Models\User::whereNotNull('phone_number')->where('phone_number', '!=', '')->get();
echo "Count: " . $usersWithPhones->count() . "\n";

foreach ($usersWithPhones as $user) {
    echo $user->name . ": " . $user->phone_number . "\n";
}

echo "\n=== Users with home diocese ===\n";
$usersWithDiocese = App\Models\User::whereNotNull('home_diocese')->where('home_diocese', '!=', '')->get();
echo "Count: " . $usersWithDiocese->count() . "\n";

foreach ($usersWithDiocese as $user) {
    echo $user->name . ": " . $user->home_diocese . "\n";
}

?>
