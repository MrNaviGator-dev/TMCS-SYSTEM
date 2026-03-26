<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Checking payment status for TMCS-0031 (User ID 31)...\n";

// Get all payments for user 31
$payments = Payment::where('user_id', 31)->get();

echo "All payments for User ID 31:\n";
foreach ($payments as $payment) {
    echo "Payment ID: {$payment->id}\n";
    echo "Amount: {$payment->amount}\n";
    echo "Status: {$payment->status}\n";
    echo "Payment Year: {$payment->payment_year}\n";
    echo "Payment Type: {$payment->payment_type}\n";
    echo "Description: {$payment->description}\n";
    echo "Created At: {$payment->created_at}\n";
    echo "Updated At: {$payment->updated_at}\n";
    echo "----------------------------------------\n";
}

echo "\nChecking specifically the 10,000 payment:\n";
$payment10k = Payment::where('user_id', 31)->where('amount', 10000)->first();

if ($payment10k) {
    echo "Found 10,000 payment:\n";
    echo "ID: {$payment10k->id}\n";
    echo "Status: {$payment10k->status}\n";
    echo "Description: {$payment10k->description}\n";
    echo "This is a TEST payment with description: '{$payment10k->description}'\n";
    
    if (strpos($payment10k->description, 'Test pending payment') !== false) {
        echo "❌ This is a TEST payment created for debugging!\n";
        echo "💡 You need to make a REAL payment through the form\n";
        echo "🔧 Or we can approve this test payment\n";
    }
} else {
    echo "❌ 10,000 payment not found\n";
}

echo "\nDo you want to:\n";
echo "1. Approve the test payment (change status to 'completed')\n";
echo "2. Delete the test payment\n";
echo "3. Keep it as is and make a real payment\n";
?>
