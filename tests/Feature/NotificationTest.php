<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_notification()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $payload = [
            'user_id' => User::factory()->create()->user_id,
            'title' => 'Test Notification',
            'message' => 'This is a test notification.',
            'type' => 'system',
        ];

        $response = $this->actingAs($admin)->post('/notifications', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('notifications', [
            'title' => 'Test Notification',
        ]);
    }

    /** @test */
    public function admin_can_update_notification()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $notification = Notification::factory()->create();

        $response = $this->actingAs($admin)->put("/notifications/{$notification->notification_id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('notifications', [
            'notification_id' => $notification->notification_id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function admin_can_delete_notification()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $notification = Notification::factory()->create();

        $response = $this->actingAs($admin)->delete("/notifications/{$notification->notification_id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('notifications', [
            'notification_id' => $notification->notification_id,
        ]);
    }

    /** @test */
    public function normal_user_cannot_create_notification()
    {
        $user = User::factory()->create(['role' => 'user']);

        $payload = [
            'user_id' => $user->user_id,
            'title' => 'Test',
            'message' => 'Test',
            'type' => 'system',
        ];

        $response = $this->actingAs($user)->post('/notifications', $payload);

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_see_their_notifications()
    {
        $user = User::factory()->create(['role' => 'user']);

        Notification::factory()->create([
            'user_id' => $user->user_id,
            'title' => 'Hello!',
        ]);

        $response = $this->actingAs($user)->get('/notifications');

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Hello!']);
    }

    /** @test */
    public function user_can_see_single_notification()
    {
        $user = User::factory()->create(['role' => 'user']);

        $notification = Notification::factory()->create([
            'user_id' => $user->user_id,
            'title' => 'Single Notification',
        ]);

        $response = $this->actingAs($user)->get("/notifications/{$notification->notification_id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Single Notification']);
    }


    /** @test */
    public function user_can_mark_notification_as_read()
    {
        $user = User::factory()->create(['role' => 'user']);

        $notification = Notification::factory()->create([
            'user_id' => $user->user_id,
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->post("/notifications/{$notification->notification_id}/mark-as-read");

        $response->assertStatus(200);
        $this->assertDatabaseHas('notifications', [
            'notification_id' => $notification->notification_id,
            'is_read' => true,
        ]);
    }

}
