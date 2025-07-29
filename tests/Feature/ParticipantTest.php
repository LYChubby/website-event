<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Participant;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat dan login user
        $this->user = User::factory()->create(['user_id' => 100]);
        $this->actingAs($this->user); // ✅ login user agar lewat auth middleware

        $this->event = Event::factory()->create(['event_id' => 200]);
        $this->ticket = Ticket::factory()->create(['ticket_id' => 300]);
    }

    /** @test */
    public function user_can_access_participant_index()
    {
        Participant::factory()->count(3)->create();
        $response = $this->get('/participants');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_participant_via_form()
    {
        $data = [
            'nama' => 'Farras',
            'user_id' => $this->user->user_id,
            'ticket_id' => $this->ticket->ticket_id,
            'event_id' => $this->event->event_id,
            'name_event' => 'LaravelConf 2025',
            'jenis_ticket' => 'VIP',
            'jumlah' => 2,
        ];

        $response = $this->post('/participants', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201); // ✅ karena return json() biasanya 201
        $this->assertDatabaseHas('participants', ['nama' => 'Farras']);
    }

    /** @test */
    public function user_can_see_detail_participant()
    {
        $participant = Participant::factory()->create();

        $response = $this->get("/participants/{$participant->participant_id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_update_participant_data()
    {
        $participant = Participant::factory()->create();

        $data = [
            'nama' => 'Updated Name',
            'user_id' => $participant->user_id,
            'ticket_id' => $participant->ticket_id,
            'event_id' => $participant->event_id,
            'name_event' => $participant->name_event,
            'jenis_ticket' => 'Online',
            'jumlah' => 5,
        ];

        $response = $this->put("/participants/{$participant->participant_id}", $data, ['Accept' => 'application/json']);
        $response->assertStatus(200); // ✅
        $this->assertDatabaseHas('participants', ['nama' => 'Updated Name']);
    }

    /** @test */
    public function user_can_delete_participant()
    {
        $participant = Participant::factory()->create();

        $response = $this->delete("/participants/{$participant->participant_id}", [], ['Accept' => 'application/json']);
        $response->assertStatus(200); // ✅
        $this->assertDatabaseMissing('participants', ['participant_id' => $participant->participant_id]);
    }

    /** @test */
    public function user_can_checkin_participant()
    {
        $participant = Participant::factory()->create();

        $response = $this->post("/participants/{$participant->participant_id}/checkin", [], ['Accept' => 'application/json']);
        $response->assertStatus(200); // ✅
        $this->assertNotNull($participant->fresh()->checkin_at);
    }
}
