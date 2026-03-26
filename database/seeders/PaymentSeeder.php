<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\User;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing payments first
        Payment::truncate();
        
        // Get a test user (you can adjust this)
        $user = User::first();
        if (!$user) {
            $this->command->error('No users found. Please create a user first.');
            return;
        }
        
        // Create sample payments
        Payment::create([
            'user_id' => $user->id,
            'payment_type' => 'membership',
            'amount' => 2000.00,
            'description' => 'Full membership fee payment - TZS 2000',
            'payment_method' => 'mobile_money_1',
            'sender_name' => $user->name,
            'installment_type' => 'full',
            'payment_year' => 2026,
            'status' => 'completed',
            'created_at' => now()->subDays(30),
            'updated_at' => now()->subDays(30)
        ]);
        
        Payment::create([
            'user_id' => $user->id,
            'payment_type' => 'zaka',
            'amount' => 2000.00,
            'description' => 'Zaka payment - TZS 2000',
            'payment_method' => 'bank_1',
            'sender_name' => $user->name,
            'payment_year' => 2026,
            'status' => 'completed',
            'created_at' => now()->subDays(15),
            'updated_at' => now()->subDays(15)
        ]);
        
        Payment::create([
            'user_id' => $user->id,
            'payment_type' => 'certificate',
            'amount' => 4000.00,
            'description' => 'Certificate fee payment for second year students and above - TZS 4000',
            'payment_method' => 'mobile_money_1',
            'sender_name' => $user->name,
            'payment_year' => 2026,
            'status' => 'pending',
            'created_at' => now()->subDays(7),
            'updated_at' => now()->subDays(7)
        ]);
        
        $this->command->info('Sample payments created successfully!');
    }
}
