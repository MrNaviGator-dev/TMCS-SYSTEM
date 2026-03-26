<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CheckUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== CHECKING USERS IN DATABASE ===');
        
        $users = DB::table('users')->get();
        
        if ($users->isEmpty()) {
            $this->command->error('No users found in database!');
            return;
        }
        
        $this->command->info('Found ' . $users->count() . ' users:');
        
        foreach ($users as $user) {
            $this->command->line("ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Phone: " . ($user->phone_number ?? 'NULL'));
        }
        
        // Get the first user and make them admin
        $firstUser = $users->first();
        $this->command->info("\n=== MAKING USER ID {$firstUser->id} ADMIN ===");
        
        DB::table('users')->where('id', $firstUser->id)->update(['role' => 'admin']);
        
        $this->command->info("User {$firstUser->name} (ID: {$firstUser->id}) is now ADMIN!");
        $this->command->info("Login with phone: {$firstUser->phone_number}");
    }
}
