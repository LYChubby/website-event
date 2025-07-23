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
        Schema::create('participants', function (Blueprint $table) {
            $table->id('participant_id');
            $table->string('nama');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->foreignId('ticket_id')->constrained('tickets', 'ticket_id');
            $table->foreignId('event_id')->constrained('events', 'event_id');

            $table->string('name_event');
            $table->enum('jenis_ticket', ['VVIP', 'VIP', 'Reguler', 'Online']);
            $table->integer('jumlah'); // total tiket yang dibeli untuk nama ini

            $table->timestamp('checkin_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
