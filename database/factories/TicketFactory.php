<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'ticket_code_prefix' => 'TEST-' . strtoupper(fake()->bothify('??##')),
            'jenis_ticket' => 'VIP',
            'price' => fake()->randomFloat(2, 50000, 1000000),
            'quantity_available' => 100,
            'quantity_sold' => 0,
            'start_pesan' => now(),
            'end_pesan' => now()->addDays(7),
            'is_active' => true,
        ];
    }
}
