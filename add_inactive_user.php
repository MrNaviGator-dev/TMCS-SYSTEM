<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Add a sample inactive user for testing
$user = new \App\Models\User();
$user->name = 'Test Inactive User';
$user->email = 'inactive@example.com';
$user->password = bcrypt('password');
$user->role = 'member';
$user->membership_status = 'Inactive'; // Set status to Inactive
$user->registration_number = 'TMCS/TEST/2024';
$user->home_diocese = 'Test Diocese';
$user->phone_number = '255712345678';
$user->gender = 'Male';
$user->year_of_study = 'Year 1';
$user->save();

echo "Test inactive user created successfully!\n";
echo "Email: inactive@example.com\n";
echo "Password: password\n";
echo "Status: Inactive\n";
