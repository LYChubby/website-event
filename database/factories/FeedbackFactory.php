<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // akan membuat user dan ambil ID-nya
            'event_id' => Event::factory(), // akan membuat event dan ambil ID-nya
            'rating' => $this->faker->numberBetween(0, 5),
            'comment' => $this->faker->sentence,
        ];
    }
}
