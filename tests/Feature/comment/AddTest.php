<?php

namespace Tests\Feature\comment;

use App\Models\Comment;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function addcomment(){

        $data= Comment::factory()->make()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->postJson('/api/Comment/Add',$data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('comments',['comment'=>$data['comment']]);
    }
    /** @test */
    public function guestcantaddcommment(){

        $data= Comment::factory()->make()->toArray();
        $response=$this->postJson('/api/Comment/Add',$data);

        $response->assertStatus(401);

    }
    /** @test */
    public function cantaddcommmentformissingcompany(){

        $data= Comment::factory(['company_id'=>0])->make()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->postJson('/api/Comment/Add',$data);
        $response->assertStatus(422);

    }


}
