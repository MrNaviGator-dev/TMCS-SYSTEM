<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Removing test payment for 2030...\n";

// Find and delete the test payment
$testPayment = Payment::where('payment_year', 2030)
    ->where('description', 'Test pending payment for Under Review demo')
    ->first();

if ($testPayment) {
    echo "Found test payment:\n";
    echo "ID: {$testPayment->id}\n";
    echo "Amount: {$testPayment->amount}\n";
    echo "Status: {$testPayment->status}\n";
    echo "Description: {$testPayment->description}\n";
    
    // Delete the test payment
    $testPayment->delete();
    
    echo "\n✅ Test payment deleted successfully!\n";
} else {
    echo "❌ Test payment not found\n";
}

echo "\nNow checking remaining payments:\n";
$allPayments = Payment::with('user')->get();

echo "All payments after deletion:\n";
foreach ($allPayments as $payment) {
    echo "ID: {$payment->id}, Year: {$payment->payment_year}, Amount: {$payment->amount}, Status: {$payment->status}, User: {$payment->user->name}\n";
}

echo "\nAvailable years now:\n";
$years = Payment::distinct('payment_year')->orderBy('payment_year', 'desc')->pluck('payment_year');
foreach ($years as $year) {
    $count = Payment::where('payment_year', $year)->count();
    echo "Year {$year}: {$count} payment(s)\n";
}

echo "\n✅ Test payment removed! Now only real payments remain.\n";
?>
