<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $events = DB::table('events')->get();
        $tickets = [];

        foreach ($events as $event) {
            $ticketTypes = ['VVIP', 'VIP', 'Reguler', 'Online'];
            $prices = [500000, 300000, 150000, 75000];

            foreach ($ticketTypes as $index => $type) {
                $quantityAvailable = $type === 'VVIP' ? 50 : ($type === 'VIP' ? 100 : ($type === 'Reguler' ? 500 : 1000));
                $quantitySold = $event->status_approval === 'approved' ? rand(0, $quantityAvailable / 2) : 0;

                $tickets[] = [
                    'event_id' => $event->event_id,
                    'ticket_code_prefix' => Str::slug($event->name_event) . '-' . $type,
                    'jenis_ticket' => $type,
                    'price' => $prices[$index],
                    'quantity_available' => $quantityAvailable,
                    'quantity_sold' => $quantitySold,
                    'start_pesan' => Carbon::now()->subDays(rand(10, 30)),
                    'end_pesan' => Carbon::parse($event->start_date)->subDays(1),
                    'is_active' => true,
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
                ];
            }
        }

        DB::table('tickets')->insert($tickets);
    }
}
