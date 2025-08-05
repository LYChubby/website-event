<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionDetailFactory extends Factory
{
    protected $model = TransactionDetail::class;

    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $this->faker->randomElement([50000, 75000, 100000]);
        return [
            'transaction_id' => Transaction::factory(),
            'ticket_id' => Ticket::factory(),
            'jenis_ticket' => $this->faker->randomElement(['VVIP', 'VIP', 'Reguler', 'Online']),
            'quantity' => $quantity,
            'price_per_ticket' => $price,
            'subtotal' => $quantity * $price,
        ];
    }
}
