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
            if (!Schema::hasColumn('users', 'registration_number')) {
                $table->string('registration_number')->nullable()->unique()->after('email');
            }
            if (!Schema::hasColumn('users', 'home_diocese')) {
                $table->string('home_diocese')->nullable()->after('registration_number');
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('home_diocese');
            }
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('phone_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['registration_number', 'home_diocese', 'phone_number', 'profile_picture'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};