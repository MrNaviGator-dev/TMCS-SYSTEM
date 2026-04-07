<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\User;

class TestAdminPayments extends Command
{
    protected $signature = 'test:admin-payments';
    protected $description = 'Test admin payments data';

    public function handle()
    {
        $this->info('Testing Admin Payments Data:');
        $this->info('----------------------------------------');
        
        // Get all payments with user data
        $payments = Payment::with('user')->get();
        
        $this->info('Total Payments: ' . $payments->count());
        
        foreach ($payments as $payment) {
            $this->line("Payment ID: {$payment->id}");
            $this->line("User ID: {$payment->user_id}");
            $this->line("User Name: " . ($payment->user ? $payment->user->name : 'NULL'));
            $this->line("User Email: " . ($payment->user ? $payment->user->email : 'NULL'));
            $this->line("Payment Type: {$payment->payment_type}");
            $this->line("Amount: TZS {$payment->amount}");
            $this->line("Status: {$payment->status}");
            $this->line("Created: {$payment->created_at}");
            $this->info('----------------------------------------');
        }
        
        // Test JSON structure
        $this->info('JSON Structure Test:');
        $this->info('----------------------------------------');
        
        $jsonData = $payments->map(function($payment) {
            return [
                'id' => $payment->id,
                'payment_type' => $payment->payment_type,
                'amount' => $payment->amount,
                'description' => $payment->description,
                'payment_method' => $payment->payment_method,
                'sender_name' => $payment->sender_name,
                'installment_type' => $payment->installment_type,
                'payment_year' => $payment->payment_year,
                'status' => $payment->status,
                'created_at' => $payment->created_at,
                'attachment' => $payment->attachment,
                'user_id' => $payment->user_id,
                'user_name' => $payment->user ? $payment->user->name : 'Unknown',
                'user_email' => $payment->user ? $payment->user->email : 'Unknown',
                'user_role' => $payment->user ? $payment->user->role : 'Unknown'
            ];
        });
        
        $this->info('Sample JSON structure:');
        $this->line(json_encode($jsonData->first(), JSON_PRETTY_PRINT));
        
        return Command::SUCCESS;
    }
}
