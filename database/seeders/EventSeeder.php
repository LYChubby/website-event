<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run()
    {
        $organizers = DB::table('users')->where('role', 'organizer')->get();
        $categories = DB::table('categories')->pluck('category_id');

        $eventNames = [
            'Annual Music Festival',
            'City Marathon',
            'Tech Summit',
            'Art Exhibition',
            'Food Festival',
            'Business Conference',
            'Charity Gala',
            'Comedy Night',
            'Fashion Show',
            'Gaming Tournament',
            'Health Expo',
            'Book Fair',
            'Film Premiere',
            'Wine Tasting',
            'Science Symposium',
            'Dance Competition',
            'Startup Pitch',
            'Photography Workshop',
            'Culinary Masterclass',
            'Music Workshop',
            'Yoga Retreat',
            'Investor Forum',
            'Poetry Slam',
            'Coding Bootcamp',
            'Sustainability Summit',
            'Film Festival',
            'Theater Performance',
            'Craft Beer Festival',
            'AI Conference',
            'Blockchain Workshop'
        ];

        $events = [];

        foreach ($organizers as $organizer) {
            // ambil nama organizer (jika tidak ada, fallback ke user_id)
            $organizerName = Str::slug($organizer->name ?? 'organizer-' . $organizer->user_id);

            // 10 past events
            for ($i = 0; $i < 10; $i++) {
                $startDate = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 24));
                $events[] = [
                    'user_id' => $organizer->user_id,
                    'category_id' => $categories->random(),
                    'name_event' => $eventNames[$i] . ' ' . date('Y') . ' - ' . $organizerName,
                    'description' => 'Description for ' . $eventNames[$i] . ' (' . $organizerName . ')',
                    'event_image' => null,
                    'venue_name' => fake()->company(),
                    'venue_address' => fake()->address(),
                    'start_date' => $startDate,
                    'end_date' => $startDate->copy()->addHours(rand(2, 8)),
                    'status_approval' => 'approved',
                    'created_at' => $startDate->copy()->subDays(rand(10, 30)),
                    'updated_at' => $startDate->copy()->subDays(rand(1, 10)),
                ];
            }

            // 10 events in 1 month
            for ($i = 10; $i < 20; $i++) {
                $startDate = Carbon::now()->addDays(rand(15, 45))->addHours(rand(1, 24));
                $events[] = [
                    'user_id' => $organizer->user_id,
                    'category_id' => $categories->random(),
                    'name_event' => $eventNames[$i] . ' ' . date('Y') . ' - ' . $organizerName,
                    'description' => 'Description for ' . $eventNames[$i] . ' (' . $organizerName . ')',
                    'event_image' => null,
                    'venue_name' => fake()->company(),
                    'venue_address' => fake()->address(),
                    'start_date' => $startDate,
                    'end_date' => $startDate->copy()->addHours(rand(2, 8)),
                    'status_approval' => 'approved',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ];
            }

            // 10 events in 2 months
            for ($i = 20; $i < 30; $i++) {
                $startDate = Carbon::now()->addDays(rand(45, 75))->addHours(rand(1, 24));
                $events[] = [
                    'user_id' => $organizer->user_id,
                    'category_id' => $categories->random(),
                    'name_event' => $eventNames[$i] . ' ' . date('Y') . ' - ' . $organizerName,
                    'description' => 'Description for ' . $eventNames[$i] . ' (' . $organizerName . ')',
                    'event_image' => null,
                    'venue_name' => fake()->company(),
                    'venue_address' => fake()->address(),
                    'start_date' => $startDate,
                    'end_date' => $startDate->copy()->addHours(rand(2, 8)),
                    'status_approval' => 'approved',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ];
            }
        }

        DB::table('events')->insert($events);
    }
}
