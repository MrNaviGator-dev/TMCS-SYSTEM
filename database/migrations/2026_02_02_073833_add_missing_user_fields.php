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
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable()->after('phone_number');
            }
            if (!Schema::hasColumn('users', 'year_of_study')) {
                $table->string('year_of_study')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('year_of_study');
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'membership_status')) {
                $table->string('membership_status')->default('pending')->after('date_of_birth');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['gender', 'year_of_study', 'address', 'date_of_birth', 'membership_status'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};