<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        $activities = [];

        // Generate activities for event creation
        $events = DB::table('events')->get();
        foreach ($events as $event) {
            $activities[] = [
                'type' => 'event',
                'title' => 'Event Created: ' . $event->name_event,
                'description' => 'A new event "' . $event->name_event . '" has been created',
                'created_at' => $event->created_at,
                'updated_at' => $event->created_at,
            ];

            if ($event->status_approval === 'approved') {
                $activities[] = [
                    'type' => 'event',
                    'title' => 'Event Approved: ' . $event->name_event,
                    'description' => 'The event "' . $event->name_event . '" has been approved',
                    'created_at' => Carbon::parse($event->created_at)->addHours(rand(1, 24)),
                    'updated_at' => Carbon::parse($event->created_at)->addHours(rand(1, 24)),
                ];
            }
        }

        // Generate activities for transactions
        $transactions = DB::table('transactions')
            ->join('events', 'transactions.event_id', '=', 'events.event_id')
            ->select('transactions.*', 'events.name_event')
            ->limit(50)
            ->get();

        foreach ($transactions as $transaction) {
            $activities[] = [
                'type' => 'transaction',
                'title' => 'Ticket Purchase: ' . $transaction->name_event,
                'description' => 'A user has purchased tickets for "' . $transaction->name_event . '"',
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->created_at,
            ];
        }

        // Generate user registration activities
        $users = DB::table('users')->limit(20)->get();
        foreach ($users as $user) {
            $activities[] = [
                'type' => 'user',
                'title' => 'New User Registration: ' . $user->name,
                'description' => $user->name . ' has registered as a ' . $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->created_at,
            ];
        }

        DB::table('activities')->insert($activities);
    }
}
