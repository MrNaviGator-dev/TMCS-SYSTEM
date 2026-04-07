<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate the API call that the frontend makes
echo "=== TESTING API ENDPOINT ===\n";

// Test the /leader/users endpoint
try {
    // Create a mock request
    $request = new Illuminate\Http\Request();
    
    // Get the UserController
    $controller = new App\Http\Controllers\Leader\UserController();
    
    // Call the index method
    $response = $controller->index($request);
    
    echo "API Response Status: " . $response->getStatusCode() . "\n";
    echo "API Response Data:\n";
    
    $data = json_decode($response->getContent(), true);
    
    if (isset($data['users'])) {
        echo "Found " . count($data['users']) . " users:\n";
        foreach ($data['users'] as $user) {
            echo "- ID: " . $user['id'] . ", Name: " . $user['name'] . ", Role: " . $user['role'] . "\n";
        }
    } else {
        echo "No users found in response\n";
        echo "Full response: " . $response->getContent() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error testing API: " . $e->getMessage() . "\n";
}

echo "\n=== DIRECT DATABASE QUERY ===\n";

// Also test direct database query
$users = App\Models\User::all(['id', 'name', 'email', 'role']);
echo "Direct query found " . $users->count() . " users:\n";
foreach ($users as $user) {
    echo "- ID: " . $user->id . ", Name: " . $user->name . ", Role: " . $user->role . "\n";
}
