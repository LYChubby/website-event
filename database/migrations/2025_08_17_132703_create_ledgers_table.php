<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            // null = admin (pemilik web), kalau ada value = organizer

            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->enum('type', ['credit', 'debit']); // credit = masuk, debit = keluar
            $table->decimal('amount', 15, 2);
            $table->string('description')->nullable();

            $table->timestamps();

            // foreign keys
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('transaction_id')->references('transaction_id')->on('transactions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
};
