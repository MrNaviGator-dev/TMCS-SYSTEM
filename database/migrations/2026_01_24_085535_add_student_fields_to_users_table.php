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
            $table->string('registration_number')->nullable()->unique()->after('email');
            $table->string('home_diocese')->nullable()->after('registration_number');
            $table->string('phone_number')->nullable()->after('home_diocese');
            $table->string('profile_picture')->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['registration_number', 'home_diocese', 'phone_number', 'profile_picture']);
        });
    }
};
