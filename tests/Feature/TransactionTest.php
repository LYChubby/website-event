<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user); // Simulasi login user
    }

    public function test_user_can_create_transaction()
    {
        $event = Event::factory()->create();

        $payload = [
            'transaction_id' => 'TRX-TEST-001',
            'no_invoice' => 'INV-JUL25-0001',
            'user_id' => $this->user->user_id,
            'event_id' => $event->event_id,
            'status_pembayaran' => 'unpaid',
            'metode_pembayaran' => 'manual',
            'total_harga' => 150000,
        ];

        $response = $this->post('/transaction', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('transactions', [
            'no_invoice' => 'INV-JUL25-0001',
            'user_id' => $this->user->user_id,
        ]);
    }

    public function test_user_can_view_transaction_detail()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->get("/transaction/{$transaction->transaction_id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'transaction_id' => $transaction->transaction_id,
                 ]);
    }

    public function test_user_can_update_transaction()
    {
        $transaction = Transaction::factory()->create([
            'status_pembayaran' => 'unpaid'
        ]);

        $response = $this->put("/transaction/{$transaction->transaction_id}", [
            'status_pembayaran' => 'paid',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', [
            'transaction_id' => $transaction->transaction_id,
            'status_pembayaran' => 'paid',
        ]);
    }

    public function test_user_can_delete_transaction()
    {
        $transaction = Transaction::factory()->create();

        $response = $this->delete("/transaction/{$transaction->transaction_id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('transactions', [
            'transaction_id' => $transaction->transaction_id,
        ]);
    }

    public function test_user_can_list_transactions()
    {
        Transaction::factory()->count(3)->create();

        $response = $this->get('/transaction');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'transaction_id',
                         'no_invoice',
                         'user_id',
                         'event_id',
                         'status_pembayaran',
                         'metode_pembayaran',
                         'total_harga',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }
}
