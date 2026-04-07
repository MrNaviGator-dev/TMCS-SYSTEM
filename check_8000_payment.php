<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Checking the 8000 payment for TMCS-0031...\n";

// Find the specific payment
$payment8000 = Payment::where('amount', 8000)
    ->where('user_id', 31)
    ->first();

if ($payment8000) {
    echo "✅ Found the 8000 payment:\n";
    echo "Payment ID: {$payment8000->id}\n";
    echo "User ID: {$payment8000->user_id} (TMCS-" . str_pad($payment8000->user_id, 4, '0') . ")\n";
    echo "Payment Type: {$payment8000->payment_type}\n";
    echo "Amount: {$payment8000->amount}\n";
    echo "Status: {$payment8000->status}\n";
    echo "Payment Year: {$payment8000->payment_year}\n";
    echo "Description: '{$payment8000->description}'\n";
    echo "Payment Method: {$payment8000->payment_method}\n";
    echo "Sender Name: {$payment8000->sender_name}\n";
    echo "Installment Type: {$payment8000->installment_type}\n";
    echo "Created At: {$payment8000->created_at}\n";
    echo "Updated At: {$payment8000->updated_at}\n";
    
    echo "\n🔍 Analysis:\n";
    if (strpos($payment8000->description, 'Test payment') !== false) {
        echo "❌ This is a TEST payment created for admin approval demo\n";
        echo "📋 Description contains: 'Test payment for admin approval demo'\n";
        echo "🎯 Purpose: To demonstrate admin approval functionality\n";
        echo "💡 Not a real payment made through the form\n";
    } else {
        echo "✅ This appears to be a real payment\n";
    }
    
    echo "\n📊 Status Analysis:\n";
    echo "Current Status: {$payment8000->status}\n";
    if ($payment8000->status === 'pending') {
        echo "🔸 Status is 'pending' (Inasubiri)\n";
        echo "💡 Needs admin approval to become 'completed'\n";
        echo "🔧 Admin buttons should allow approval\n";
    } else {
        echo "✅ Status is '{$payment8000->status}'\n";
    }
    
} else {
    echo "❌ 8000 payment not found for TMCS-0031\n";
}

echo "\nChecking all payments for TMCS-0031 (User ID 31):\n";
$allPayments31 = Payment::where('user_id', 31)->get();

foreach ($allPayments31 as $payment) {
    echo "ID: {$payment->id}, Year: {$payment->payment_year}, Amount: {$payment->amount}, Status: {$payment->status}, Description: '{$payment->description}'\n";
}

echo "\n📊 Summary:\n";
echo "Total payments for TMCS-0031: " . $allPayments31->count() . "\n";
echo "Total amount: " . $allPayments31->sum('amount') . "\n";
echo "Pending payments: " . $allPayments31->where('status', 'pending')->count() . "\n";
echo "Completed payments: " . $allPayments31->where('status', 'completed')->count() . "\n";
?>
