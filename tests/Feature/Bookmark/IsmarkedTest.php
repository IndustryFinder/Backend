<?php

namespace Tests\Feature\Bookmark;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IsmarkedTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function HasTheUserMarkedThisCampony()
    {
        $data= Bookmark::factory()->create()->toArray();
        $this->actingAs(User::find($data['user_id']));
        $response = $this->getJson("/api/user/bookmarks/IsMarked/${data['id']}");
        $response->assertStatus(200);
    }
    /** @test */
    public function GuestCantSeeIfTheyMarkedThisCompany(){
        $data= Bookmark::factory()->create()->toArray();
        $response = $this->getJson("/api/user/bookmarks/IsMarked/${data['id']}");
        $response->assertStatus(401);
    }
}
