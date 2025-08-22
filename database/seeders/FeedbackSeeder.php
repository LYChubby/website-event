<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        $participants = DB::table('participants')->limit(50)->get();

        foreach ($participants as $p) {
            DB::table('feedbacks')->insert([
                'user_id' => $p->user_id,
                'event_id' => $p->event_id,
                'rating' => rand(3, 5),
                'comment' => fake()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
