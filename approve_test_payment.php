<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Approving the test payment (Payment ID 5)...\n";

// Approve the test payment
$payment = Payment::find(5);
if ($payment) {
    $payment->status = 'completed';
    $payment->admin_description = 'Test payment approved for demonstration';
    $payment->save();
    
    echo "✅ Test payment approved!\n";
    echo "📊 Payment details:\n";
    echo "   ID: {$payment->id}\n";
    echo "   Amount: {$payment->amount}\n";
    echo "   Status: {$payment->status}\n";
    echo "   Admin Description: {$payment->admin_description}\n";
    echo "   Payment Year: {$payment->payment_year}\n";
} else {
    echo "❌ Payment not found\n";
}

echo "\nNow checking 2029 payments:\n";
$payments2029 = Payment::with('user')->where('payment_year', 2029)->get();

$totalAmount = 0;
$completedCount = 0;

foreach ($payments2029 as $payment) {
    echo "Payment ID: {$payment->id}\n";
    echo "User: {$payment->user->name}\n";
    echo "Amount: {$payment->amount}\n";
    echo "Status: {$payment->status}\n";
    echo "Description: {$payment->description}\n";
    echo "----------------------------------------\n";
    
    $totalAmount += $payment->amount;
    if ($payment->status === 'completed') {
        $completedCount++;
    }
}

echo "\n📊 2029 Summary:\n";
echo "💰 Total Amount: TZS {$totalAmount}\n";
echo "📊 Completed: {$completedCount}/" . count($payments2029) . "\n";

echo "\n✅ Now refresh your page - the 10,000 payment should show 'Imekamilika'\n";
?>
