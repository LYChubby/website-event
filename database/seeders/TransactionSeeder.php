<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->where('role', 'user')->limit(20)->get();
        $events = DB::table('events')->where('status_approval', 'approved')->get();
        $transactions = [];

        // For past events (generate more transactions)
        $pastEvents = $events->where('start_date', '<', now());

        foreach ($pastEvents as $event) {
            $eventUsers = $users->random(rand(5, 10)); // 5-15 users per past event
            foreach ($eventUsers as $user) {
                $transactions[] = [
                    'user_id' => $user->user_id,
                    'event_id' => $event->event_id,
                    'no_invoice' => 'INV-' . strtoupper(Str::random(5)) . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'total_price' => 0, // Will be calculated in details
                    'status_pembayaran' => 'paid',
                    'payment_method' => ['Bank Transfer', 'Credit Card', 'E-Wallet'][rand(0, 2)],
                    'created_at' => Carbon::parse($event->start_date)->subDays(rand(1, 30)),
                    'updated_at' => Carbon::parse($event->start_date)->subDays(rand(1, 30)),
                ];
            }
        }

        // For upcoming events (fewer transactions)
        $upcomingEvents = $events->where('start_date', '>', now());

        foreach ($upcomingEvents as $event) {
            $eventUsers = $users->random(rand(2, 8)); // 2-8 users per upcoming event
            foreach ($eventUsers as $user) {
                $transactions[] = [
                    'user_id' => $user->user_id,
                    'event_id' => $event->event_id,
                    'no_invoice' => 'INV-' . strtoupper(Str::random(5)) . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'total_price' => 0, // Will be calculated in details
                    'status_pembayaran' => ['paid', 'pending'][rand(0, 1)],
                    'payment_method' => ['Bank Transfer', 'Credit Card', 'E-Wallet'][rand(0, 2)],
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ];
            }
        }

        // Insert transactions and get their IDs
        $transactionIds = [];
        foreach (array_chunk($transactions, 500) as $chunk) {
            DB::table('transactions')->insert($chunk);
            $lastId = DB::getPdo()->lastInsertId();
            for ($i = 0; $i < count($chunk); $i++) {
                $transactionIds[] = $lastId + $i;
            }
        }

        // Now create transaction details
        $this->createTransactionDetails($transactionIds, $transactions);
    }

    protected function createTransactionDetails($transactionIds, $transactions)
    {
        $details = [];

        foreach ($transactionIds as $index => $transactionId) {
            $eventId = $transactions[$index]['event_id'];
            $tickets = DB::table('tickets')
                ->where('event_id', $eventId)
                ->inRandomOrder()
                ->limit(rand(1, 3)) // 1-3 ticket types per transaction
                ->get();

            $totalPrice = 0;

            foreach ($tickets as $ticket) {
                $quantity = rand(1, ($ticket->jenis_ticket === 'VVIP' ? 2 : 4));
                $subtotal = $quantity * $ticket->price;
                $totalPrice += $subtotal;

                $details[] = [
                    'transaction_id' => $transactionId,
                    'ticket_id' => $ticket->ticket_id,
                    'jenis_ticket' => $ticket->jenis_ticket,
                    'quantity' => $quantity,
                    'price_per_ticket' => $ticket->price,
                    'subtotal' => $subtotal,
                    'created_at' => $transactions[$index]['created_at'],
                    'updated_at' => $transactions[$index]['created_at'],
                ];
            }

            // Update transaction total price
            DB::table('transactions')
                ->where('transaction_id', $transactionId)
                ->update(['total_price' => $totalPrice]);
        }

        foreach (array_chunk($details, 500) as $chunk) {
            DB::table('transaction_details')->insert($chunk);
        }
    }
}
