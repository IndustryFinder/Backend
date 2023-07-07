<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function getallcategories()
    {

        Category::factory()->count(5)->create();
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);

    }
    /** @test */
    public function testShowValidCategory(){
        // Create a category in the database
        $category = Category::factory()->create();

        // Call the show method with the valid category ID
        $response = $this->getJson('/api/category/show/' . $category->id);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson($category->toArray());
    }
    /** @test */
    public function testShowInvalidCategory()
    {
        // Call the show method with an invalid category ID
        $response = $this->getJson('/api/category/show/999');

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Category not found']);
    }
}
