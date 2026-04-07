<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Simulating frontend payment loading...\n";

// Simulate what the frontend should receive
$payments = Payment::with('user')->get()->map(function($payment) {
    return [
        'id' => $payment->id,
        'user_id' => $payment->user_id,
        'user_name' => $payment->user ? $payment->user->name : 'Unknown User',
        'payment_type' => $payment->payment_type,
        'amount' => $payment->amount,
        'payment_year' => $payment->payment_year,
        'status' => $payment->status,
        'date' => $payment->created_at->format('Y-m-d')
    ];
});

echo "Frontend payment data:\n";
foreach ($payments as $payment) {
    echo "ID: {$payment['id']}, Year: {$payment['payment_year']}, Amount: {$payment['amount']}, Status: {$payment['status']}\n";
}

// Check year filtering logic
$allPayments = $payments->toArray();
$targetYear = 2029;
$yearPayments = array_filter($allPayments, function($p) use ($targetYear) {
    return $p['payment_year'] == $targetYear && $p['status'] === 'completed';
});

echo "\nFiltering for 2029 completed payments:\n";
foreach ($yearPayments as $payment) {
    echo "Found: ID {$payment['id']}, Amount {$payment['amount']}\n";
}

$yearTotal = array_sum(array_column($yearPayments, 'amount'));
$remainingBalance = 30000 - $yearTotal;

echo "Year total: {$yearTotal}\n";
echo "Remaining balance: {$remainingBalance}\n";

// Check unique years for filter
$uniqueYears = array_unique(array_column($allPayments, 'payment_year'));
sort($uniqueYears);
echo "\nUnique years for filter: " . implode(', ', $uniqueYears) . "\n";
