<?php

namespace Database\Factories;

use App\Models\Disbursement;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisbursementFactory extends Factory
{
    protected $model = Disbursement::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 10000, 500000),
            'platform_fee' => $this->faker->randomFloat(2, 500, 10000),
            'status' => $this->faker->randomElement(['sent', 'completed', 'failed']),
            'external_disbursement_id' => $this->faker->uuid(),
            'disbursed_at' => now(),
        ];
    }
}
