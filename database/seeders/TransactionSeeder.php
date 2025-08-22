<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->where('role', 'user')->pluck('user_id');
        $tickets = DB::table('tickets')->get();

        foreach ($tickets as $ticket) {
            // Ambil data event untuk ticket ini
            $event = DB::table('events')->where('event_id', $ticket->event_id)->first();

            if (!$event) {
                continue; // Skip jika event tidak ditemukan
            }

            // Tentukan apakah transaksi Paid atau Pending (50% chance masing-masing)
            $isPaid = rand(0, 1);
            $quantity = rand(1, 5);

            if ($isPaid) {
                // Transaksi PAID
                $subtotal = $ticket->price * $quantity;
                $adminFee = $subtotal * 0.10;
                $organizerIncome = $subtotal - $adminFee;

                $transactionId = DB::table('transactions')->insertGetId([
                    'user_id' => $users->random(),
                    'event_id' => $ticket->event_id,
                    'no_invoice' => 'INV-' . strtoupper(Str::random(10)),
                    'total_price' => $subtotal,
                    'status_pembayaran' => 'Paid',
                    'payment_method' => fake()->randomElement(['Xendit', 'Bank Transfer', 'Credit Card', 'QRIS']),
                    'pending_quantity' => 0, // Tidak ada pending untuk transaksi paid
                    'pending_nama' => null,  // Tidak ada pending untuk transaksi paid
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);

                // Insert Transaction Detail
                DB::table('transaction_details')->insert([
                    'transaction_id' => $transactionId,
                    'ticket_id' => $ticket->ticket_id,
                    'jenis_ticket' => $ticket->jenis_ticket,
                    'quantity' => $quantity,
                    'price_per_ticket' => $ticket->price,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update ticket sold
                DB::table('tickets')->where('ticket_id', $ticket->ticket_id)->increment('quantity_sold', $quantity);

                // Ledger untuk organizer (90%)
                DB::table('ledgers')->insert([
                    'user_id' => $event->user_id,
                    'transaction_id' => $transactionId,
                    'type' => 'credit',
                    'amount' => $organizerIncome,
                    'description' => 'Organizer income from ticket sales - ' . $event->name_event,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Ledger untuk admin (10%)
                DB::table('ledgers')->insert([
                    'user_id' => null,
                    'transaction_id' => $transactionId,
                    'type' => 'credit',
                    'amount' => $adminFee,
                    'description' => 'Admin fee (10%) from ticket sales - ' . $event->name_event,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Participants untuk transaksi PAID
                $participantNames = [];
                for ($i = 0; $i < $quantity; $i++) {
                    $checkinAt = fake()->boolean(70) // 70% chance checkin
                        ? Carbon::parse(fake()->dateTimeBetween(
                            $event->start_date,
                            $event->end_date
                        ))->format('Y-m-d H:i:s')
                        : null;

                    $participantName = fake()->name();
                    $participantNames[] = $participantName;

                    DB::table('participants')->insert([
                        'transaction_id' => $transactionId,
                        'nama' => $participantName,
                        'user_id' => $users->random(),
                        'ticket_id' => $ticket->ticket_id,
                        'event_id' => $ticket->event_id,
                        'name_event' => DB::table('events')->where('event_id', $ticket->event_id)->value('name_event'),
                        'jenis_ticket' => $ticket->jenis_ticket,
                        'jumlah' => $quantity,
                        'checkin_at' => $checkinAt,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                // Transaksi PENDING
                $subtotal = $ticket->price * $quantity;
                $pendingNames = [];

                // Generate random names untuk pending
                for ($i = 0; $i < $quantity; $i++) {
                    $pendingNames[] = fake()->name();
                }

                $transactionId = DB::table('transactions')->insertGetId([
                    'user_id' => $users->random(),
                    'event_id' => $ticket->event_id,
                    'no_invoice' => 'INV-' . strtoupper(Str::random(10)),
                    'total_price' => $subtotal,
                    'status_pembayaran' => 'Pending',
                    'payment_method' => fake()->randomElement(['Xendit', 'Bank Transfer', 'Credit Card', 'QRIS']),
                    'pending_quantity' => $quantity, // Quantity yang pending
                    'pending_nama' => implode(', ', $pendingNames), // Nama-nama yang pending
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);

                // Insert Transaction Detail (untuk pending juga dibuat detailnya)
                DB::table('transaction_details')->insert([
                    'transaction_id' => $transactionId,
                    'ticket_id' => $ticket->ticket_id,
                    'jenis_ticket' => $ticket->jenis_ticket,
                    'quantity' => $quantity,
                    'price_per_ticket' => $ticket->price,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Untuk transaksi pending, TIDAK update ticket sold dan TIDAK buat ledger
                // Juga TIDAK buat participants karena status masih pending

                // Optional: Buat participants tapi dengan status khusus atau null data
                // for ($i = 0; $i < $quantity; $i++) {
                //     DB::table('participants')->insert([
                //         'transaction_id' => $transactionId,
                //         'nama' => $pendingNames[$i],
                //         'user_id' => null, // User ID null karena pending
                //         'ticket_id' => $ticket->ticket_id,
                //         'event_id' => $ticket->event_id,
                //         'name_event' => $event->title,
                //         'jenis_ticket' => $ticket->jenis_ticket,
                //         'jumlah' => 1,
                //         'checkin_at' => null, // Belum checkin karena pending
                //         'created_at' => now(),
                //         'updated_at' => now(),
                //     ]);
                // }
            }
        }
    }
}
