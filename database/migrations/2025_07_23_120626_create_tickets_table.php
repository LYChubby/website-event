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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->onDelete('cascade');

            $table->string('ticket_code_prefix'); // Contoh: JMF25-VVIP
            $table->enum('jenis_ticket', ['VVIP', 'VIP', 'Reguler', 'Online']);
            $table->decimal('price', 12, 2);
            $table->integer('quantity_available');
            $table->integer('quantity_sold')->default(0);

            $table->dateTime('start_pesan');
            $table->dateTime('end_pesan');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
