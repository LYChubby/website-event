<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    public function test_user_can_create_ticket()
    {
        $user = $this->authenticate();

        $event = Event::factory()->create([
            'user_id' => $user->user_id,
        ]);

        $response = $this->post('/tickets', [
            'event_id' => $event->event_id,
            'ticket_code_prefix' => 'TEST-VVIP',
            'jenis_ticket' => 'VVIP',
            'price' => 100000,
            'quantity_available' => 50,
            'start_pesan' => now(),
            'end_pesan' => now()->addDays(7),
            'is_active' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tickets', ['ticket_code_prefix' => 'TEST-VVIP']);
    }

    public function test_user_can_update_ticket()
    {
        $user = $this->authenticate();

        $event = Event::factory()->create([
            'user_id' => $user->user_id,
        ]);

        $ticket = Ticket::factory()->create([
            'event_id' => $event->event_id,
            'price' => 50000,
        ]);

        $response = $this->put("/tickets/{$ticket->ticket_id}", [
            'price' => 75000,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tickets', ['ticket_id' => $ticket->ticket_id, 'price' => 75000]);
    }

    public function test_user_can_delete_ticket()
    {
        $user = $this->authenticate();

        $event = Event::factory()->create([
            'user_id' => $user->user_id,
        ]);

        $ticket = Ticket::factory()->create([
            'event_id' => $event->event_id,
        ]);

        $response = $this->delete("/tickets/{$ticket->ticket_id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tickets', ['ticket_id' => $ticket->ticket_id]);
    }
}
