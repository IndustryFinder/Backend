<?php

namespace Tests\Feature\comment;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function testGetByUser()
    {
        $comments= Comment::factory(['user_id'=>50])->count(5)->create();
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->getJson("/api/Comment/GetByUser/50");
        $response->assertStatus(200);
        $response->assertJson($comments->toArray());
    }
}
