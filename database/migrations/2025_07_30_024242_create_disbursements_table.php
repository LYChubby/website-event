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
        Schema::create('disbursements', function (Blueprint $table) {
            $table->id('disbursement_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');

            $table->decimal('amount', 12, 2); // jumlah yang ditransfer ke organizer
            $table->decimal('platform_fee', 12, 2); // komisi platform
            $table->string('status')->default('sent'); // sent, completed, failed
            $table->string('external_disbursement_id')->nullable(); // ID dari Xendit
            $table->timestamp('disbursed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disbursements');
    }
};
