<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('home_diocese')->nullable();
            $table->string('year_of_study')->nullable();
            $table->string('role')->default('user');
            $table->string('registration_number')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('membership_status')->default('Active');
            $table->date('registration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'gender', 
                'home_diocese',
                'year_of_study',
                'role',
                'registration_number',
                'profile_picture',
                'membership_status',
                'registration_date'
            ]);
        });
    }
};
