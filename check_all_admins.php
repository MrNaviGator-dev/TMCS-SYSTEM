<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$allUsers = \App\Models\User::all();
echo 'All users with admin role:' . PHP_EOL;
foreach ($allUsers as $user) {
    if ($user->role === 'admin') {
        echo 'ID: ' . $user->id . ' - Name: ' . $user->name . ' - Email: ' . $user->email . ' - Profile: ' . ($user->profile_picture ?: 'NULL') . PHP_EOL;
    }
}

echo PHP_EOL . 'All users in database:' . PHP_EOL;
foreach ($allUsers as $user) {
    echo 'ID: ' . $user->id . ' - Name: ' . $user->name . ' - Role: ' . $user->role . ' - Profile: ' . ($user->profile_picture ?: 'NULL') . PHP_EOL;
}
?>
