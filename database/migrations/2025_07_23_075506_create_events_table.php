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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->foreignId('user_id')->constrained('users'); // Organizer
            $table->foreignId('category_id')->constrained('categories');

            $table->string('name_event');
            $table->text('description');
            $table->string('event_image')->nullable();
            $table->string('venue_name');
            $table->text('venue_address');

            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status_approval', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
