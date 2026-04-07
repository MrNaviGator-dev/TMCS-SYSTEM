<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Checking payments...\n";

$payments = Payment::all();

foreach ($payments as $payment) {
    echo "ID: {$payment->id}, User: {$payment->user_id}, Year: {$payment->payment_year}, Amount: {$payment->amount}, Status: {$payment->status}, Type: {$payment->payment_type}\n";
}

echo "\nTotal payments: " . $payments->count() . "\n";
