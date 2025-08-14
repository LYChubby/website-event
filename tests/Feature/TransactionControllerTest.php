<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Login user sebelum setiap test
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_list_all_transactions()
    {
        Transaction::factory()->count(3)->create();

        $response = $this->getJson('/transaction');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_show_a_single_transaction()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->getJson('/transaction/' . $transaction->transaction_id);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'transaction_id' => $transaction->transaction_id
                 ]);
    }

    /** @test */
    public function it_can_create_a_transaction()
    {
        $event = Event::factory()->create([
            'end_date' => now()->addDays(5), // belum expired
        ]);

        $payload = [
            'user_id' => $this->user->id,
            'event_id' => $event->id,
            'no_invoice' => 'INV-TEST-0001',
            'total_price' => 50000,
            'status_pembayaran' => 'pending',
            'payment_method' => 'bank_transfer',
        ];

        $response = $this->postJson('/transaction', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'message' => 'Transaction created successfully'
                 ]);
    }

    /** @test */
    public function it_cannot_create_transaction_if_event_expired()
    {
        $event = Event::factory()->create([
            'end_date' => now()->subDay(), // expired
        ]);

        $payload = [
            'user_id' => $this->user->id,
            'event_id' => $event->id,
            'no_invoice' => 'INV-TEST-0002',
            'total_price' => 50000,
            'status_pembayaran' => 'pending',
            'payment_method' => 'bank_transfer',
        ];

        $response = $this->postJson('/transaction', $payload);

        $response->assertStatus(403)
                 ->assertJsonFragment([
                     'message' => 'Tidak bisa membeli tiket untuk event yang sudah berakhir.'
                 ]);
    }

    /** @test */
    public function it_can_update_a_transaction()
    {
        $transaction = Transaction::factory()->create();

        $payload = [
            'total_price' => 75000,
            'status_pembayaran' => 'paid',
        ];

        $response = $this->putJson('/transaction/' . $transaction->transaction_id, $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'message' => 'Transaction updated successfully'
                 ]);
    }

    /** @test */
    public function it_can_delete_a_transaction()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->deleteJson('/transaction/' . $transaction->transaction_id);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'message' => 'Transaction deleted successfully'
                 ]);
    }
}



// namespace Tests\Feature;

// use Tests\TestCase;
// use App\Models\User;
// use App\Models\Event;
// use App\Models\Transaction;
// use App\Models\Notification;
// use App\Mail\PaymentStatusMail;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Support\Facades\Mail;

// class TransactionControllerTest extends TestCase
// {
//     use RefreshDatabase;

//     public function test_index_returns_transactions()
//     {
//         $user = User::factory()->create();
//         Transaction::factory()->count(3)->create();

//         $this->actingAs($user)
//             ->getJson('/transaction')
//             ->assertStatus(200)
//             ->assertJsonCount(3);
//     }

//     public function test_store_creates_transaction()
//     {
//         $user = User::factory()->create();
//         $event = Event::factory()->create(['is_expired' => false]);

//         $payload = [
//             'user_id' => $user->user_id,
//             'event_id' => $event->event_id,
//             'no_invoice' => 'INV-123',
//             'total_price' => 50000,
//             'status_pembayaran' => 'pending'
//         ];

//         $this->actingAs($user)
//             ->postJson('/transaction', $payload)
//             ->assertStatus(201)
//             ->assertJsonFragment(['no_invoice' => 'INV-123']);
//     }

//     public function test_store_fails_for_expired_event()
//     {
//         $user = User::factory()->create();
//         $event = Event::factory()->create(['is_expired' => true]);

//         $payload = [
//             'user_id' => $user->user_id,
//             'event_id' => $event->event_id,
//             'no_invoice' => 'INV-999',
//             'total_price' => 100000,
//             'status_pembayaran' => 'pending'
//         ];

//         $this->actingAs($user)
//             ->postJson('/transaction', $payload)
//             ->assertStatus(403)
//             ->assertJsonFragment(['message' => 'Tidak bisa membeli tiket untuk event yang sudah berakhir.']);
//     }

//     public function test_update_sends_email_and_notification_on_success()
//     {
//         Mail::fake();
//         $buyer = User::factory()->create();
//         $organizer = User::factory()->create();
//         $event = Event::factory()->create(['user_id' => $organizer->user_id]);
//         $transaction = Transaction::factory()->create([
//             'user_id' => $buyer->user_id,
//             'event_id' => $event->event_id,
//             'status_pembayaran' => 'pending'
//         ]);

//         $this->actingAs($buyer)
//             ->putJson("/transaction/{$transaction->transaction_id}", [
//                 'status_pembayaran' => 'success'
//             ])
//             ->assertStatus(200)
//             ->assertJsonFragment(['status_pembayaran' => 'success']);

//         Mail::assertQueued(PaymentStatusMail::class, 2); // buyer & organizer
//         $this->assertDatabaseHas('notifications', [
//             'user_id' => $buyer->user_id,
//             'title' => 'Pembayaran Berhasil'
//         ]);
//         $this->assertDatabaseHas('notifications', [
//             'user_id' => $organizer->user_id,
//             'title' => 'Tiket Terjual'
//         ]);
//     }

//     public function test_destroy_deletes_transaction()
//     {
//         $user = User::factory()->create();
//         $transaction = Transaction::factory()->create();

//         $this->actingAs($user)
//             ->deleteJson("/transaction/{$transaction->transaction_id}")
//             ->assertStatus(200)
//             ->assertJsonFragment(['message' => 'Transaction deleted successfully']);

//         $this->assertDatabaseMissing('transactions', [
//             'transaction_id' => $transaction->transaction_id
//         ]);
//     }
// }
