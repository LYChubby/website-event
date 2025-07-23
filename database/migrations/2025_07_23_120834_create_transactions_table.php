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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('event_id')->constrained('events', 'event_id');
            $table->string('no_invoice')->unique(); // e.g. INV-JMF25-0001
            $table->decimal('total_price', 12, 2);
            $table->enum('status_pembayaran', ['pending', 'paid', 'expired'])->default('pending');
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
