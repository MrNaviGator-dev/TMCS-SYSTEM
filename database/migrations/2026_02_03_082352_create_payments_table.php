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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_type'); // membership, certificate, zaka
            $table->decimal('amount', 10, 2);
            $table->text('description');
            $table->string('payment_method', 100); // mobile_money_X, bank_X
            $table->string('sender_name', 255);
            $table->string('installment_type', 50)->nullable(); // full, installment1, etc.
            $table->integer('payment_year');
            $table->string('attachment')->nullable(); // file path
            $table->string('status', 20)->default('pending'); // pending, completed, failed
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('payment_type');
            $table->index('payment_year');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
