<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        $pastEvents = DB::table('events')
            ->where('status_approval', 'approved')
            ->where('start_date', '<', now())
            ->get();

        $users = DB::table('users')->where('role', 'user')->get();
        $feedbacks = [];

        foreach ($pastEvents as $event) {
            $eventAttendees = DB::table('participants')
                ->where('event_id', $event->event_id)
                ->distinct('user_id')
                ->pluck('user_id');

            foreach ($eventAttendees->random(min(5, $eventAttendees->count())) as $userId) {
                $feedbacks[] = [
                    'user_id' => $userId,
                    'event_id' => $event->event_id,
                    'rating' => rand(3, 5), // Most ratings will be positive
                    'comment' => $this->generateFeedbackComment($event->name_event),
                    'created_at' => Carbon::parse($event->start_date)->addDays(rand(1, 7)),
                    'updated_at' => Carbon::parse($event->start_date)->addDays(rand(1, 7)),
                ];
            }
        }

        DB::table('feedbacks')->insert($feedbacks);
    }

    protected function generateFeedbackComment($eventName)
    {
        $comments = [
            "Great event! Would definitely attend again.",
            "The organization was excellent. Everything ran smoothly.",
            "Enjoyed every moment of " . $eventName . "!",
            "The venue was perfect for this type of event.",
            "Speakers/knowledge was top-notch at " . $eventName . ".",
            "Well worth the ticket price. Had an amazing time!",
            "Some areas could be improved, but overall a good experience.",
            "The food and beverages were excellent.",
            "Met some really interesting people at this event.",
            "Would recommend to anyone interested in this topic."
        ];

        return $comments[array_rand($comments)];
    }
}
