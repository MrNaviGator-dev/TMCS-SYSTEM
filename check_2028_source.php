<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Checking all payments in database...\n";

$allPayments = Payment::with('user')->get();

echo "All payments:\n";
foreach ($allPayments as $payment) {
    echo "ID: {$payment->id}\n";
    echo "User ID: {$payment->user_id}\n";
    echo "User Name: " . ($payment->user ? $payment->user->name : 'Unknown User') . "\n";
    echo "Payment Type: {$payment->payment_type}\n";
    echo "Amount: {$payment->amount}\n";
    echo "Status: {$payment->status}\n";
    echo "Payment Year: {$payment->payment_year}\n";
    echo "Description: {$payment->description}\n";
    echo "Created At: {$payment->created_at}\n";
    echo "----------------------------------------\n";
}

echo "\nChecking specifically for year 2028:\n";
$payments2028 = Payment::where('payment_year', 2028)->get();

echo "Found {$payments2028->count()} payments for 2028:\n";
foreach ($payments2028 as $payment) {
    echo "Payment ID: {$payment->id}\n";
    echo "User ID: {$payment->user_id}\n";
    echo "User Name: " . ($payment->user ? $payment->user->name : 'Unknown User') . "\n";
    echo "Amount: {$payment->amount}\n";
    echo "Status: {$payment->status}\n";
    echo "Description: {$payment->description}\n";
    echo "Created At: {$payment->created_at}\n";
    echo "----------------------------------------\n";
}

echo "\nAll years with payments:\n";
$years = Payment::distinct('payment_year')->orderBy('payment_year', 'desc')->pluck('payment_year');
foreach ($years as $year) {
    $count = Payment::where('payment_year', $year)->count();
    echo "Year {$year}: {$count} payment(s)\n";
}
?>
