<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\User;

class CheckUserIDs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:userids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user IDs in payments table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking Payment User IDs:');
        $this->info('----------------------------------------');
        
        $payments = Payment::with('user')->get();
        
        foreach ($payments as $payment) {
            $this->line("Payment ID: {$payment->id}");
            $this->line("User ID: {$payment->user_id}");
            $this->line("User Name: " . ($payment->user ? $payment->user->name : 'NULL'));
            $this->line("Payment Type: {$payment->payment_type}");
            $this->line("Amount: TZS {$payment->amount}");
            $this->info('----------------------------------------');
        }
        
        $this->info('All Users in Database:');
        $this->info('----------------------------------------');
        
        $users = User::all();
        foreach ($users as $user) {
            $this->line("User ID: {$user->id}");
            $this->line("Name: {$user->name}");
            $this->line("Email: {$user->email}");
            $this->line("Role: {$user->role}");
            $this->info('----------------------------------------');
        }
        
        return Command::SUCCESS;
    }
}
