<?php

namespace Tests\Feature\Bookmark;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class storeTest extends TestCase
{
    use RefreshDatabase;
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
        $response = $this->postJson("/api/user/bookmarks/add",$data);
        $response->assertStatus(201);
    }

    /** @test */
    public function guestcantdaddbookmark(){

        $data= Bookmark::factory()->make()->toArray();
        $response=$this->postJson("/api/user/bookmarks/add",$data);
        $response->assertStatus(401);

    }
    /** @test */
    public function cantAddBookmarkformissingcompany(){
        $data= Bookmark::factory(['marked_id'=>0])->create()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->postJson("/api/user/bookmarks/add",$data);
        $response->assertStatus(422);

    }
}
