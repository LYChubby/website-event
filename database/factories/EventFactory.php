<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

   public function definition(): array
{
    return [
        'event_id' => $this->faker->unique()->randomNumber(5), // tambahkan ini
        'user_id' => User::factory(),
        'category_id' => \App\Models\Category::factory(),
        'name_event' => $this->faker->sentence(3),
        'description' => $this->faker->paragraph(),
        'event_image' => null,
        'venue_name' => $this->faker->company(),
        'venue_address' => $this->faker->address(),
        'start_date' => now()->addDays(7),
        'end_date' => now()->addDays(8),
        'status_approval' => 'approved',
    ];
}

}
