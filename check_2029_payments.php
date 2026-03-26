<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Checking all payments with years...\n";

$payments = Payment::all();

foreach ($payments as $payment) {
    echo "ID: {$payment->id}, Year: {$payment->payment_year}, Amount: {$payment->amount}, Status: {$payment->status}, Type: {$payment->payment_type}\n";
}

echo "\nTotal payments: " . $payments->count() . "\n";

// Check for 2029 payments
$payments2029 = Payment::where('payment_year', 2029)->get();
echo "Payments for 2029: " . $payments2029->count() . "\n";

if ($payments2029->count() > 0) {
    foreach ($payments2029 as $payment) {
        echo "2029 Payment: ID {$payment->id}, Amount {$payment->amount}, Status {$payment->status}\n";
    }
}
