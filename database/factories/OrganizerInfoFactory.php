<?php

namespace Database\Factories;

use App\Models\OrganizerInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizerInfoFactory extends Factory
{
    protected $model = OrganizerInfo::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bank_account_name' => $this->faker->name,
            'bank_account_number' => $this->faker->numerify('##########'),
            'bank_code' => $this->faker->randomElement(['BCA', 'MANDIRI', 'BRI']),
            'is_verified' => $this->faker->boolean,
            'disbursement_ready' => $this->faker->boolean,
        ];
    }
}
