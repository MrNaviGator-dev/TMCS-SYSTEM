<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$admins = \App\Models\User::where('role', 'admin')->get();
foreach ($admins as $admin) {
    echo 'Admin: ' . $admin->name . ' (ID: ' . $admin->id . ') - Profile: ' . ($admin->profile_picture ?: 'NULL') . PHP_EOL;
}
?>
