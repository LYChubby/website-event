<?php

namespace Database\Factories;

use App\Models\Participant;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'user_id' => User::factory()->create()->user_id,
            'ticket_id' => Ticket::factory()->create()->ticket_id,
            'event_id' => Event::factory()->create()->event_id,
            'name_event' => $this->faker->sentence,
            'jenis_ticket' => $this->faker->randomElement(['VVIP', 'VIP', 'Reguler', 'Online']),
            'jumlah' => $this->faker->numberBetween(1, 5),
            'checkin_at' => null,
        ];
    }
}
