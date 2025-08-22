<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $events = Event::all();

        foreach ($events as $event) {
            $startDate = Carbon::parse($event->start_date);

            DB::table('tickets')->insert([
                'event_id' => $event->event_id,
                'ticket_code_prefix' => strtoupper(substr($event->name_event, 0, 3)) . rand(100, 999),
                'jenis_ticket' => ['VVIP', 'VIP', 'Reguler', 'Online'][rand(0, 3)],
                'price' => [200000, 150000, 100000, 75000][rand(0, 3)],
                'quantity_available' => 100,
                'quantity_sold' => 0,
                'start_pesan' => $startDate->copy()->subDays(30),
                'end_pesan' => $startDate,
            ]);
        }
    }
}
