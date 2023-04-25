<?php

namespace Tests\Feature\category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
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
}
