<?php

namespace Tests\Feature\Bookmark;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function test_example()
    {
        $data= Bookmark::factory()->create()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response = $this->getJson('/api/user/bookmarks');
        $response->assertStatus(200);
    }

    /** @test */
    public function GuestDontHaveBookmark(){
        $data= Bookmark::factory()->create()->toArray();
        $response=$this->getJson('/api/user/bookmarks');
        $response->assertStatus(401);

    }
}
