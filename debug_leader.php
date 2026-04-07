<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING LEADER USER CONTROLLER ===\n";

// Test the UserController directly
try {
    $controller = new App\Http\Controllers\Leader\UserController();
    $request = new Illuminate\Http\Request();
    
    echo "Calling UserController::index()...\n";
    $response = $controller->index($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Content:\n";
    
    $data = json_decode($response->getContent(), true);
    
    if (isset($data['users'])) {
        echo "Found " . count($data['users']) . " users in API response:\n";
        foreach ($data['users'] as $user) {
            echo "- ID: " . $user['id'] . " | Name: " . $user['name'] . " | Role: " . $user['role'] . "\n";
        }
    } else {
        echo "No users found in API response\n";
        echo "Full response: " . $response->getContent() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error testing UserController: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== CHECKING USER MODEL ===\n";

// Check if Watson Boniface exists in database
$watson = App\Models\User::where('id', 2)->first();
if ($watson) {
    echo "Watson Boniface found in database:\n";
    echo "- ID: " . $watson->id . "\n";
    echo "- Name: " . $watson->name . "\n";
    echo "- Email: " . $watson->email . "\n";
    echo "- Role: " . $watson->role . "\n";
    echo "- Created at: " . $watson->created_at . "\n";
} else {
    echo "Watson Boniface NOT found in database!\n";
}

echo "\n=== ALL USERS FROM DATABASE ===\n";

$allUsers = App\Models\User::all(['id', 'name', 'email', 'role']);
echo "Total users in database: " . $allUsers->count() . "\n\n";

foreach ($allUsers as $user) {
    echo "ID: " . $user->id . " | Name: " . $user->name . " | Role: " . $user->role . "\n";
}
