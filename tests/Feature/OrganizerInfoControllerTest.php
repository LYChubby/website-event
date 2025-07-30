<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\OrganizerInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizerInfoControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_organizer_infos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        OrganizerInfo::factory()->count(3)->create();

        $response = $this->getJson('/organizer-infos');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function can_create_organizer_info()
    {
        $authUser = User::factory()->create();
        $this->actingAs($authUser);

        $payload = [
            'user_id' => $authUser->user_id,
            'bank_account_name' => 'John Doe',
            'bank_account_number' => '123456789',
            'bank_code' => 'BCA',
            'is_verified' => true,
            'disbursement_ready' => false,
        ];

        $response = $this->postJson('/organizer-infos', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['bank_account_name' => 'John Doe']);

        $this->assertDatabaseHas('organizers_infos', ['user_id' => $authUser->user_id]);
    }

    /** @test */
    public function can_show_specific_organizer_info()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $organizer = OrganizerInfo::factory()->create();

        $response = $this->getJson("/organizer-infos/{$organizer->organizer_info_id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['bank_account_number' => $organizer->bank_account_number]);
    }

    /** @test */
    public function can_update_organizer_info()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $organizer = OrganizerInfo::factory()->create(['user_id' => $user->user_id]);

        $update = [
            'user_id' => $user->user_id,
            'bank_account_name' => 'Updated Name',
            'bank_account_number' => '987654321',
            'bank_code' => 'MANDIRI',
            'is_verified' => true,
            'disbursement_ready' => true,
        ];

        $response = $this->putJson("/organizer-infos/{$organizer->organizer_info_id}", $update);

        $response->assertStatus(200)
                 ->assertJsonFragment(['bank_account_name' => 'Updated Name']);
    }

    /** @test */
    public function can_delete_organizer_info()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $organizer = OrganizerInfo::factory()->create(['user_id' => $user->user_id]);

        $response = $this->deleteJson("/organizer-infos/{$organizer->organizer_info_id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Organizer info deleted successfully.']);

        $this->assertDatabaseMissing('organizers_infos', [
            'organizer_info_id' => $organizer->organizer_info_id,
        ]);
    }
}


// namespace Tests\Feature;

// use App\Models\OrganizerInfo;
// use App\Models\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;

// class OrganizerInfoControllerTest  extends TestCase
// {
//     use RefreshDatabase;

//     public function test_authenticated_user_can_see_organizer_info_create_form()
//     {
//         $user = User::factory()->create();

//         $response = $this->actingAs($user)->get('/organizer-infos/create');

//         $response->assertOk();
//         $response->assertSee('Bank Account Name'); // Atau teks lain dari view
//     }

//     public function test_authenticated_user_can_store_organizer_info()
//     {
//         $user = User::factory()->create();

//         $data = [
//             'user_id' => $user->user_id,
//             'bank_account_name' => 'Test User',
//             'bank_account_number' => '1234567890',
//             'bank_code' => 'BCA',
//         ];

//         $response = $this->actingAs($user)->post('/organizer-infos', $data);

//         $response->assertRedirect(); // biasanya redirect ke index atau show
//         $this->assertDatabaseHas('organizers_infos', [
//             'user_id' => $user->user_id,
//             'bank_account_name' => 'Test User',
//         ]);
//     }

//     public function test_authenticated_user_can_see_edit_page()
//     {
//         $info = OrganizerInfo::factory()->create();

//         $response = $this->actingAs($info->user)->get("/organizer-infos/{$info->organizer_info_id}/edit");

//         $response->assertOk();
//         $response->assertSee('Edit');
//     }

//     public function test_authenticated_user_can_update_organizer_info()
//     {
//         $info = OrganizerInfo::factory()->create();

//         $updated = [
//             'user_id' => $info->user_id,
//             'bank_account_name' => 'Updated Name',
//             'bank_account_number' => '987654321',
//             'bank_code' => 'MANDIRI',
//         ];

//         $response = $this->actingAs($info->user)->put("/organizer-infos/{$info->organizer_info_id}", $updated);

//         $response->assertRedirect();
//         $this->assertDatabaseHas('organizers_infos', [
//             'organizer_info_id' => $info->organizer_info_id,
//             'bank_account_name' => 'Updated Name',
//         ]);
//     }

//     public function test_authenticated_user_can_delete_organizer_info()
//     {
//         $info = OrganizerInfo::factory()->create();

//         $response = $this->actingAs($info->user)->delete("/organizer-infos/{$info->organizer_info_id}");

//         $response->assertRedirect();
//         $this->assertDatabaseMissing('organizers_infos', [
//             'organizer_info_id' => $info->organizer_info_id,
//         ]);
//     }
// }
