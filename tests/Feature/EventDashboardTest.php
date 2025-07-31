<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_dashboard_displays_correct_metrics()
    {
        // Arrange: Buat user organizer & login
        $organizer = User::factory()->create(['role' => 'organizer']);
        $this->actingAs($organizer);

        // Buat 2 event milik organizer agar totalEvent = 2
        $events = Event::factory()->count(2)->create([
            'user_id' => $organizer->user_id,
        ]);

        // Pilih salah satu event untuk dashboard
        $event = $events->first();

        // Buat 1 tiket untuk event
        $ticket = Ticket::factory()->create([
            'event_id' => $event->event_id,
            'price' => 100000,
            'quantity_available' => 100,
        ]);

        // Buat 2 peserta menggunakan tiket tersebut
        Participant::factory()->count(2)->create([
            'event_id' => $event->event_id,
            'ticket_id' => $ticket->ticket_id,
        ]);

        // Act: Akses dashboard
        $response = $this->get("/organizer/events/{$event->event_id}/dashboard");

        // Assert: Data dashboard tampil
        $response->assertStatus(200);
        $response->assertSeeText($event->name);
        $response->assertSeeText('Total Event');
        $response->assertSeeText('Total Tiket');
        $response->assertSeeText('Total Pendapatan');
        $response->assertSeeText('100'); // jumlah tiket tersedia
        $response->assertSeeText('Rp 200.000'); // 2 peserta x 100.000
    }
}
