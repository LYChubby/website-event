<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_store_feedback(): void
    {
        // 🔥 PENTING: user harus punya role 'user'
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $event = Event::factory()->create();

        $this->actingAs($user);

        $feedbackData = [
            'event_id' => $event->event_id,
            'rating' => 4,
            'comment' => 'Acara sangat bagus!',
        ];

        $response = $this->post('/feedbacks', $feedbackData);

        $response->assertStatus(201); // Created
        $this->assertDatabaseHas('feedbacks', [
            'user_id' => $user->user_id,
            'event_id' => $event->event_id,
            'rating' => 4,
            'comment' => 'Acara sangat bagus!',
        ]);
    }



    /** @test */
    public function organizer_cannot_store_feedback()
    {
        // Organizer tidak boleh kirim feedback
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create();

        $this->actingAs($organizer);

        $response = $this->postJson('/feedbacks', [
            'event_id' => $event->event_id,
            'rating' => 5,
            'comment' => 'Should not be allowed',
        ]);

        $response->assertStatus(403); // forbidden
    }

    /** @test */
    public function user_can_view_feedback_list()
    {
        $user = User::factory()->create(['role' => 'user']);
        Feedback::factory()->count(3)->create();

        $this->actingAs($user);

        $response = $this->getJson('/feedbacks');

        $response->assertStatus(200)
            ->assertJsonCount(3); // pastikan 3 feedback tampil
    }

    /** @test */
    public function admin_can_delete_feedback()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $feedback = Feedback::factory()->create();

        $this->actingAs($admin);

        $response = $this->deleteJson('/feedbacks/' . $feedback->feedback_id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('feedbacks', [
            'feedback_id' => $feedback->feedback_id, // gunakan PK dari migration
        ]);
    }

    /** @test */
    public function non_admin_cannot_delete_feedback()
    {
        $user = User::factory()->create(['role' => 'user']);
        $feedback = Feedback::factory()->create();

        $this->actingAs($user);

        $response = $this->deleteJson('/feedbacks/' . $feedback->feedback_id);

        $response->assertStatus(403); // akses ditolak
    }
}
