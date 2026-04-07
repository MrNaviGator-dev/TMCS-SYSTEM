<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Removing the test payment for 2028...\n";

// Find and delete the test payment
$testPayment = Payment::where('payment_year', 2028)
    ->where('description', 'Test payment for admin approval demo - 8,000 TZS')
    ->first();

if ($testPayment) {
    echo "Found test payment:\n";
    echo "ID: {$testPayment->id}\n";
    echo "Amount: {$testPayment->amount}\n";
    echo "Status: {$testPayment->status}\n";
    echo "Description: {$testPayment->description}\n";
    echo "Year: {$testPayment->payment_year}\n";
    
    // Delete the test payment
    $testPayment->delete();
    
    echo "\n✅ Test payment deleted successfully!\n";
} else {
    echo "❌ Test payment not found\n";
}

echo "\nNow checking remaining payments for TMCS-0031:\n";
$remainingPayments = Payment::where('user_id', 31)->get();

echo "Remaining payments:\n";
foreach ($remainingPayments as $payment) {
    echo "ID: {$payment->id}, Year: {$payment->payment_year}, Amount: {$payment->amount}, Status: {$payment->status}\n";
}

echo "\nAvailable years now:\n";
$years = Payment::distinct('payment_year')->orderBy('payment_year', 'desc')->pluck('payment_year');
foreach ($years as $year) {
    $count = Payment::where('payment_year', $year)->count();
    echo "Year {$year}: {$count} payment(s)\n";
}

echo "\n✅ Test payment removed! Now only real payments remain.\n";
echo "📊 No more 2028 section in payment history.\n";
?>
