<?php

// namespace Tests\Feature;

// use App\Models\Transaction;
// use App\Models\User;
// use App\Models\Event;
// use App\Models\Participant;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;

// class HistoryControllerTest extends TestCase
// {
//     use RefreshDatabase;

//     /** @test */
//     public function user_can_view_their_transaction_history()
//     {
//         $user = User::factory()->create();
//         $this->actingAs($user);

//         // Butuh data Participant karena controller ambil dari table itu
//         $event = Event::factory()->create();

//         // Buat transaksi dan participant terkait
//         $transactions = Transaction::factory()->count(3)->create([
//             'user_id' => $user->id,
//             'event_id' => $event->id,
//         ]);

//         foreach ($transactions as $transaction) {
//             Participant::factory()->create([
//                 'user_id' => $user->id,
//                 'event_id' => $transaction->event_id,
//                 'name_event' => $transaction->event->name,
//             ]);
//         }

//         // Transaksi milik user lain (harus diabaikan)
//         Transaction::factory()->count(2)->create();

//         $response = $this->get(route('history.index'));

//         $response->assertStatus(200);
//         $response->assertViewIs('history.index');
//         $response->assertViewHas('histories', function ($histories) use ($user) {
//             return $histories->every(fn($h) => $h->nama_pembeli !== null && $h->status_pembayaran !== null);
//         });
//     }

//     /** @test */
//     public function user_can_view_single_transaction_detail()
//     {
//         $user = User::factory()->create();
//         $this->actingAs($user);

//         $event = Event::factory()->create();

//         $transaction = Transaction::factory()->create([
//             'user_id' => $user->id,
//             'event_id' => $event->id,
//         ]);

//         Participant::factory()->create([
//             'user_id' => $user->id,
//             'event_id' => $event->id,
//         ]);

//         $response = $this->get(route('history.show', $transaction->transaction_id));

//         $response->assertStatus(200);
//         $response->assertViewIs('history.show');
//         $response->assertViewHas('transaction', fn($t) => $t->id === $transaction->id);
//         $response->assertViewHas('participants');
//     }

//     /** @test */
//     public function user_cannot_view_others_transaction_detail()
//     {
//         $user = User::factory()->create();
//         $otherUser = User::factory()->create();

//         $this->actingAs($user);

//         $transaction = Transaction::factory()->create([
//             'user_id' => $otherUser->id,
//         ]);

//         $response = $this->get(route('history.show', $transaction->transaction_id));
//         $response->assertStatus(403); // agar ini berhasil, perlu validasi akses di controllermu
//     }

//     /** @test */
//     public function guest_cannot_view_transaction_history()
//     {
//         $response = $this->get(route('history.index'));
//         $response->assertRedirect(route('login'));
//     }

//     /** @test */
//     public function guest_cannot_view_transaction_detail()
//     {
//         $transaction = Transaction::factory()->create();
//         $response = $this->get(route('history.show', $transaction->transaction_id));
//         $response->assertRedirect(route('login'));
//     }
// }



namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_history_for_authenticated_user()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id]);

        $participant = Participant::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_id' => $ticket->id,
            'name_event' => $event->nama,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/history');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'transaction_id' => $transaction->transaction_id,
            'nama_pembeli' => $participant->nama,
            'nama_event' => $event->nama,
            'status_pembayaran' => $transaction->status_pembayaran,
        ]);
    }

    public function test_show_returns_transaction_detail()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id]);

        $participant = Participant::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_id' => $ticket->id,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $detail = TransactionDetail::factory()->create([
            'transaction_id' => $transaction->transaction_id,
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/history/' . $transaction->transaction_id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id_transaksi' => $transaction->transaction_id,
            'nama_user' => $user->name,
            'event' => $event->nama,
            'status_pembayaran' => $transaction->status_pembayaran,
            'item' => $detail->item_name,
            'jumlah' => $detail->quantity,
            'harga' => $detail->price,
            'total' => $detail->total,
        ]);
    }
}
