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
    /**@test*/
    public function guestcantdeletecomment(){

        $data= Comment::factory()->create()->toArray();
        $response=$this->deleteJson("/api/Comment/Delete/${data['id']}");
        $response->assertStatus(401);

    }
    /**@test*/
    public function cantdeletecommentformissingcompany(){

        $data= Comment::factory(['company_id'=>0])->create()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->deleteJson("/api/Comment/Delete/${data['id']}");
        $response->assertStatus(422);

    }

}
