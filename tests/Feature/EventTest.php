<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_create_event()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $category = Category::factory()->create();

        $payload = [
            'category_id' => $category->category_id,
            'name_event' => 'Konser Musik',
            'description' => 'Konser musik terbesar tahun ini.',
            'venue_name' => 'Stadion Utama',
            'venue_address' => 'Jl. Merdeka No.1',
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(6)->format('Y-m-d'),
        ];

        $response = $this->actingAs($organizer)
            ->postJson('/events', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('events', [
            'name_event' => 'Konser Musik',
            'user_id' => $organizer->user_id,
        ]);
    }

    // public function test_can_count_events_for_organizer(): void
    // {
    //     $organizer = User::factory()->create(['role' => 'organizer']);

    //     // Buat 3 event untuk organizer
    //     Event::factory()->count(3)->create([
    //         'user_id' => $organizer->user_id,
    //     ]);

    //     // Autentikasi sebagai organizer
    //     $this->actingAs($organizer);

    //     // Hitung langsung dari model
    //     $eventCount = Event::where('user_id', $organizer->user_id)->count();

    //     // Atau jika ada endpoint khusus untuk ini:
    //     // $response = $this->getJson('/api/organizer/events/count');
    //     // $response->assertOk()->assertJson(['count' => 3]);

    //     $this->assertEquals(3, $eventCount);
    // }


    public function test_organizer_can_update_event()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->for($organizer, 'organizer')->create();

        $response = $this->actingAs($organizer)
            ->putJson("/events/{$event->event_id}", [
                'venue_name' => 'Venue Baru',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('events', [
            'event_id' => $event->event_id,
            'venue_name' => 'Venue Baru',
        ]);
    }

    public function test_organizer_can_delete_event()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->for($organizer, 'organizer')->create();

        $response = $this->actingAs($organizer)
            ->deleteJson("/events/{$event->event_id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('events', [
            'event_id' => $event->event_id,
        ]);
    }

    public function test_organizer_can_see_their_events()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        Event::factory()->count(3)->for($organizer, 'organizer')->create();

        $response = $this->actingAs($organizer)
            ->getJson('/organizer/events');

        $response->assertStatus(200);
    }


    public function test_admin_can_approve_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->for($organizer, 'organizer')->create([
            'status_approval' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->putJson("/admin/events/{$event->event_id}/approve");

        $response->assertStatus(200);
        $this->assertDatabaseHas('events', [
            'event_id' => $event->event_id,
            'status_approval' => 'approved',
        ]);
    }

    public function test_admin_can_reject_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->for($organizer, 'organizer')->create([
            'status_approval' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->putJson("/admin/events/{$event->event_id}/reject");

        $response->assertStatus(200);
        $this->assertDatabaseHas('events', [
            'event_id' => $event->event_id,
            'status_approval' => 'rejected',
        ]);
    }

    public function test_non_admin_cannot_approve_event()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->for($organizer, 'organizer')->create([
            'status_approval' => 'pending',
        ]);

        $response = $this->actingAs($organizer)
            ->putJson("/admin/events/{$event->event_id}/approve");

        $response->assertStatus(403);
    }

}
