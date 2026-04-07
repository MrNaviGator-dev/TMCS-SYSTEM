<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing users to have registration_date = created_at
        DB::statement('UPDATE users SET registration_date = created_at WHERE registration_date IS NULL');
        
        // Also update email_verified_at for existing users if null
        DB::statement('UPDATE users SET email_verified_at = created_at WHERE email_verified_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this as it's just updating data
    }
};
