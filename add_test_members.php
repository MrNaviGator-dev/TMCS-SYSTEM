<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ADDING TEST MEMBERS ===\n";

// Add test members
$testMembers = [
    [
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'phone' => '255712345678',
        'role' => 'member',
        'password' => Hash::make('password123')
    ],
    [
        'name' => 'Michael Johnson',
        'email' => 'michael.johnson@example.com',
        'phone' => '255712345679',
        'role' => 'member',
        'password' => Hash::make('password123')
    ],
    [
        'name' => 'Sarah Williams',
        'email' => 'sarah.williams@example.com',
        'phone' => '255712345680',
        'role' => 'member',
        'password' => Hash::make('password123')
    ]
];

foreach ($testMembers as $memberData) {
    try {
        // Check if user already exists
        $existingUser = App\Models\User::where('email', $memberData['email'])->first();
        if ($existingUser) {
            echo "User already exists: " . $memberData['name'] . "\n";
            continue;
        }
        
        // Create new user
        $user = new App\Models\User();
        $user->name = $memberData['name'];
        $user->email = $memberData['email'];
        $user->phone = $memberData['phone'];
        $user->role = $memberData['role'];
        $user->password = $memberData['password'];
        $user->email_verified_at = now();
        $user->save();
        
        echo "Added member: " . $memberData['name'] . "\n";
        
    } catch (Exception $e) {
        echo "Error adding " . $memberData['name'] . ": " . $e->getMessage() . "\n";
    }
}

echo "\n=== UPDATED USER LIST ===\n";

$allUsers = App\Models\User::all(['id', 'name', 'email', 'role']);
echo "Total users: " . $allUsers->count() . "\n\n";

foreach ($allUsers as $user) {
    echo "ID: " . $user->id . " | Name: " . $user->name . " | Role: " . $user->role . "\n";
}

echo "\n=== ROLE BREAKDOWN ===\n";
$roles = App\Models\User::select('role', \DB::raw('count(*) as count'))
    ->groupBy('role')
    ->get();

foreach ($roles as $role) {
    echo $role->role . ": " . $role->count . "\n";
}
