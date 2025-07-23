<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    public function test_index_returns_all_categories()
    {
        $this->authenticate();
        Category::factory()->count(3)->create();

        $response = $this->getJson('/categories');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_store_creates_category()
    {
        $this->authenticate();
        $response = $this->postJson('/categories', ['name' => 'Test Category']);
        $response->assertStatus(201)->assertJsonFragment(['name' => 'Test Category']);
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }

    public function test_show_returns_single_category()
    {
        $this->authenticate();
        $category = Category::factory()->create();

        $response = $this->getJson("/categories/{$category->category_id}");
        $response->assertStatus(200)->assertJsonFragment(['category_id' => $category->category_id]);
    }

    public function test_update_modifies_category()
    {
        $this->authenticate();
        $category = Category::factory()->create(['name' => 'Old Name']);

        $response = $this->putJson("/categories/{$category->category_id}", ['name' => 'Updated Name']);
        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated Name']);
        $this->assertDatabaseHas('categories', [
            'category_id' => $category->category_id,
            'name' => 'Updated Name'
        ]);
    }

    public function test_destroy_deletes_category()
    {
        $this->authenticate();
        $category = Category::factory()->create();

        $response = $this->deleteJson("/categories/{$category->category_id}");
        $response->assertStatus(200)->assertJson(['message' => 'Category deleted.']);
        $this->assertDatabaseMissing('categories', ['category_id' => $category->category_id]);
    }
}
