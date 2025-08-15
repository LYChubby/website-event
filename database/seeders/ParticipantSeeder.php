<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ParticipantSeeder extends Seeder
{
    public function run()
    {
        $transactionDetails = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.transaction_id')
            ->join('tickets', 'transaction_details.ticket_id', '=', 'tickets.ticket_id')
            ->join('events', 'tickets.event_id', '=', 'events.event_id')
            ->select(
                'transaction_details.*',
                'transactions.user_id',
                'tickets.event_id',
                'events.name_event',
                'events.start_date'
            )
            ->get();

        $participants = [];

        foreach ($transactionDetails as $detail) {
            $isPastEvent = Carbon::parse($detail->start_date)->isPast();

            // Buat satu record participant dengan jumlah sesuai quantity
            $participants[] = [
                'transaction_id' => $detail->transaction_id,
                'nama' => fake()->name(), // atau bisa digenerate nama untuk setiap quantity jika diperlukan
                'user_id' => $detail->user_id,
                'ticket_id' => $detail->ticket_id,
                'event_id' => $detail->event_id,
                'name_event' => $detail->name_event,
                'jenis_ticket' => $detail->jenis_ticket,
                'jumlah' => $detail->quantity, // Pertahankan jumlah asli dari transaction detail
                'checkin_at' => $isPastEvent && rand(0, 1) ? Carbon::parse($detail->start_date)->addHours(rand(0, 3)) : null,
                'created_at' => $detail->created_at,
                'updated_at' => $detail->created_at,
            ];
        }

        foreach (array_chunk($participants, 500) as $chunk) {
            DB::table('participants')->insert($chunk);
        }
    }
}
