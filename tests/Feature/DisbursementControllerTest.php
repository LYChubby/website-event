<?php

namespace Tests\Feature;

use App\Models\Disbursement;
use App\Models\Event;
use App\Models\User;
use App\Models\OrganizersInfo; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisbursementControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_disbursements(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->user_id]);

        Disbursement::factory()->count(3)->create([
            'user_id' => $user->user_id,
            'event_id' => $event->event_id,
        ]);

        $response = $this->getJson('/disbursements');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

   
    public function user_can_create_disbursement()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Buat organizers_infos terkait user
        $organizer = OrganizersInfo::factory()->create([
            'user_id' => $user->user_id,
        ]);

        // Buat event yang terkait user
        $event = Event::factory()->create([
            'user_id' => $user->user_id,
        ]);

        // Payload untuk membuat disbursement
        $payload = [
            'event_id' => $event->event_id,
            'amount' => 1000000,
            'platform_fee' => 5000,
            'status' => 'sent',
            'external_disbursement_id' => 'ext-12345',
        ];

        $response = $this->postJson('/disbursements', $payload);

        $response->assertCreated();
        $this->assertDatabaseHas('disbursements', [
            'event_id' => $event->event_id,
            'user_id' => $user->user_id,
            'amount' => 1000000,
        ]);
    }
    public function test_can_show_disbursement(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->user_id]);

        $disbursement = Disbursement::factory()->create([
            'user_id' => $user->user_id,
            'event_id' => $event->event_id,
            'amount' => 50000
        ]);

        $response = $this->getJson("/disbursements/{$disbursement->disbursement_id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['amount' => 50000.00]);
    }

    public function test_can_update_disbursement(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->user_id]);

        $disbursement = Disbursement::factory()->create([
            'user_id' => $user->user_id,
            'event_id' => $event->event_id,
            'amount' => 100000,
            'platform_fee' => 5000,
            'status' => 'sent'
        ]);

        $response = $this->putJson("/disbursements/{$disbursement->disbursement_id}", [
            'event_id' => $event->event_id,
            'amount' => 100000,
            'platform_fee' => 5000,
            'status' => 'completed',
            'external_disbursement_id' => $disbursement->external_disbursement_id,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'completed']);

        $this->assertDatabaseHas('disbursements', [
            'disbursement_id' => $disbursement->disbursement_id,
            'status' => 'completed'
        ]);
    }

    public function test_can_delete_disbursement(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->user_id]);

        $disbursement = Disbursement::factory()->create([
            'user_id' => $user->user_id,
            'event_id' => $event->event_id,
        ]);

        $response = $this->deleteJson("/disbursements/{$disbursement->disbursement_id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Disbursement deleted successfully']);


        $this->assertDatabaseMissing('disbursements', [
            'disbursement_id' => $disbursement->disbursement_id
        ]);
    }
}
