<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => $this->faker->unique()->randomNumber(5), // tambahkan ini
            'event_id' => Event::factory(),
            'ticket_code_prefix' => 'TEST-' . strtoupper($this->faker->bothify('??##')),
            'jenis_ticket' => 'VIP',
            'price' => $this->faker->randomFloat(2, 50000, 1000000),
            'quantity_available' => 100,
            'quantity_sold' => 0,
            'start_pesan' => now(),
            'end_pesan' => now()->addDays(7),
            'is_active' => true,
        ];
    }

}
