<?php

namespace Tests\Feature\Bookmark;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class storeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function makebookmark()
    {
        $data= Bookmark::factory()->make()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response = $this->postJson('/user/bookmarks/add/{id}',$data['marked_id']);
        $response->assertStatus(200);
    }

    /**@test*/
    public function guestcantdaddbookmark(){

        $data= Bookmark::factory()->make()->toArray();
        $response=$this->postJson('/user/bookmarks/add/{id}',$data);
        $response->assertStatus(401);

    }
    /**@test*/
    public function cantAddBookmarkformissingcompany(){

        $data= Bookmark::factory(['company_id'=>0])->make()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->postJson('/user/bookmarks/add/{id}',$data);
        $response->assertStatus(422);

    }
}
