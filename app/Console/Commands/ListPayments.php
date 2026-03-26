<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\User;

class ListPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all payments in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $payments = Payment::with('user')->get();
        
        $this->info('Payments (' . $payments->count() . '):');
        $this->info('----------------------------------------');
        
        foreach ($payments as $payment) {
            $this->line("ID: {$payment->id}");
            $this->line("User: {$payment->user->name} ({$payment->user->role})");
            $this->line("Type: {$payment->payment_type}");
            $this->line("Amount: TZS {$payment->amount}");
            $this->line("Status: {$payment->status}");
            $this->line("Year: {$payment->payment_year}");
            $this->line("Created: {$payment->created_at}");
            $this->info('----------------------------------------');
        }
        
        return Command::SUCCESS;
    }
}
