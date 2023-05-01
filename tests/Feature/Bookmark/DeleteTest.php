<?php

namespace Tests\Feature\Bookmark;

use App\Models\Bookmark;
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
     */
    /** @test */
    public function DeleteBookmark()
    {
        $data= Bookmark::factory()->create()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response=$this->deleteJson("/api/user/bookmarks/del/${data['id']}");
        $response->assertStatus(200);
    }

    /** @test */
    public function GuestCantDelete(){

        $data= Bookmark::factory()->create()->toArray();

        $response=$this->deleteJson("/api/user/bookmarks/del/${data['id']}");

        $response->assertStatus(401);

    }
}
