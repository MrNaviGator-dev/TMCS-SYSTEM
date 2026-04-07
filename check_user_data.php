<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;
use App\Models\User;

echo "Checking user data for payments...\n";

// Check all payments with user relationships
$payments = Payment::with('user')->get();

echo "All payments with user data:\n";
foreach ($payments as $payment) {
    echo "Payment ID: {$payment->id}\n";
    echo "User ID: {$payment->user_id}\n";
    echo "Payment Type: {$payment->payment_type}\n";
    echo "Amount: {$payment->amount}\n";
    echo "Status: {$payment->status}\n";
    echo "Payment Year: {$payment->payment_year}\n";
    
    if ($payment->user) {
        echo "User Name: {$payment->user->name}\n";
        echo "User Email: {$payment->user->email}\n";
        echo "User Role: {$payment->user->role}\n";
    } else {
        echo "USER RELATIONSHIP NOT LOADED!\n";
    }
    
    echo "----------------------------------------\n";
}

echo "\nChecking specific user ID 31:\n";
$user31 = User::find(31);
if ($user31) {
    echo "User 31 exists:\n";
    echo "Name: {$user31->name}\n";
    echo "Email: {$user31->email}\n";
    echo "Role: {$user31->role}\n";
} else {
    echo "User 31 NOT FOUND!\n";
}

echo "\nChecking user ID 1:\n";
$user1 = User::find(1);
if ($user1) {
    echo "User 1 exists:\n";
    echo "Name: {$user1->name}\n";
    echo "Email: {$user1->email}\n";
    echo "Role: {$user1->role}\n";
} else {
    echo "User 1 NOT FOUND!\n";
}
?>
