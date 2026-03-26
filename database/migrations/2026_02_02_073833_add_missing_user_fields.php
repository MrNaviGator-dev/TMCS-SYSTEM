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
            $table->string('gender')->nullable()->after('phone_number');
            $table->string('year_of_study')->nullable()->after('gender');
            $table->text('address')->nullable()->after('year_of_study');
            $table->date('date_of_birth')->nullable()->after('address');
            $table->string('membership_status')->default('pending')->after('date_of_birth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'year_of_study', 'address', 'date_of_birth', 'membership_status']);
        });
    }
};
