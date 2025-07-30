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
        Schema::create('organizers_infos', function (Blueprint $table) {
            $table->id('organizer_info_id');
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users', 'user_id')
                ->onDelete('cascade');

            $table->string('bank_account_name');
            $table->string('bank_account_number');
            $table->string('bank_code'); // contoh: BCA, MANDIRI, BRI

            $table->boolean('is_verified')->default(false); // bisa diverifikasi oleh admin
            $table->boolean('disbursement_ready')->default(false); // digunakan sistem untuk memastikan sudah layak disburse

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizers_infos');
    }
};
