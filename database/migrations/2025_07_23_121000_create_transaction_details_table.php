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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions', 'transaction_id')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('tickets', 'ticket_id');
            $table->enum('jenis_ticket', ['VVIP', 'VIP', 'Reguler', 'Online']);
            $table->integer('quantity');
            $table->decimal('price_per_ticket', 12, 2);
            $table->decimal('subtotal', 12, 2); // quantity x price_per_ticket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
