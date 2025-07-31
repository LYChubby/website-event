<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // akan otomatis buat user dan ambil user_id custom
            'event_id' => Event::factory(), // akan otomatis buat event dan ambil event_id custom
            'no_invoice' => 'INV-' . strtoupper(Str::random(4)) . '-' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'total_price' => $this->faker->randomFloat(2, 10000, 1000000),
            'status_pembayaran' => $this->faker->randomElement(['pending', 'paid', 'expired']),
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'ewallet', 'credit_card']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
