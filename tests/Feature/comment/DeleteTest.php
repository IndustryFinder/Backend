<?php

namespace Tests\Feature\comment;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function deletecomment(){

        $data= Comment::factory()->create()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->deleteJson("/api/Comment/Delete/${data['id']}");
        $response->assertStatus(200);

    }
    /** @test */
    public function cantDeleteOtherUsersComment(){

        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $anotherUser=User::factory()->create()->toArray();
        $comment= Comment::factory(['user_id'=>$anotherUser['id']])->create()->toArray();
        $response=$this->deleteJson("/api/Comment/Delete/${comment['id']}");
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);
        $this->assertDatabaseHas('comments', ['id' => $comment['id']]); // Comment should not be deleted
    }
    /** @test */
    public function guestcantdeletecomment(){

        $data= Comment::factory()->create()->toArray();
        $response=$this->deleteJson("/api/Comment/Delete/${data['id']}");
        $response->assertStatus(401);

    }


}
