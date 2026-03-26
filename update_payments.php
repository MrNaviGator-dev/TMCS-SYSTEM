<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Updating existing payments with correct status...\n";

$payments = Payment::all();

foreach ($payments as $payment) {
    // Update payment_year to 2026 and status to 'completed' (not 'success')
    $payment->payment_year = 2026;
    $payment->status = 'completed';
    $payment->save();
    
    echo "Updated payment ID: {$payment->id} - Year: {$payment->payment_year}, Status: {$payment->status}\n";
}

echo "\nUpdated {$payments->count()} payments\n";
