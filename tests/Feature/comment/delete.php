<?php

namespace Tests\Feature\comment;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class delete extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function deletecomment(){

        $data= Comment::factory()->make()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->deleteJson('/Comment/Add',$data);
        $response->assertStatus(200);

    }
    /**@test*/
    public function guestcantdeletecomment(){

        $data= Comment::factory()->make()->toArray();
        $response=$this->deleteJson('/Comment/Add',$data);
        $response->assertStatus(401);

    }
    /**@test*/
    public function cantdeletecommentformissingcompany(){

        $data= Comment::factory(['company_id'=>0])->make()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->deleteJson('/Comment/Add',$data);
        $response->assertStatus(422);

    }

}
