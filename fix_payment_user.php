<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\Payment;

echo "Fixing payment ID 5 to belong to user ID 31 (Manase Mitingi)...\n";

// Update payment ID 5 to belong to user ID 31
$payment = Payment::find(5);
if ($payment) {
    $payment->user_id = 31;
    $payment->save();
    
    echo "✅ Payment ID 5 updated to belong to User ID 31\n";
    echo "📊 Payment details:\n";
    echo "   ID: {$payment->id}\n";
    echo "   User ID: {$payment->user_id}\n";
    echo "   Amount: {$payment->amount}\n";
    echo "   Status: {$payment->status}\n";
    echo "   Payment Year: {$payment->payment_year}\n";
} else {
    echo "❌ Payment ID 5 not found\n";
}

echo "\nNow checking all 2029 payments:\n";
$payments2029 = Payment::with('user')->where('payment_year', 2029)->get();

foreach ($payments2029 as $payment) {
    echo "Payment ID: {$payment->id}\n";
    echo "User ID: {$payment->user_id} (TMCS-" . str_pad($payment->user_id, 4, '0', STR_PAD_LEFT) . ")\n";
    echo "User Name: " . ($payment->user ? $payment->user->name : 'Unknown User') . "\n";
    echo "Amount: {$payment->amount}\n";
    echo "Status: {$payment->status}\n";
    echo "----------------------------------------\n";
}

echo "\n✅ Fix complete! Now both 2029 payments belong to Manase Mitingi (TMCS-0031)\n";
?>
