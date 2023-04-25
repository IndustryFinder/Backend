<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
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
    public function DeleteAd()
    {
        $data= Ad::factory()->create()->toArray();
        $this->actingAs(User::find($data['sender']));
        $response=$this->deleteJson("/api/ad/del/${data['id']}");
        $response->assertStatus(200);
    }

    /**@test*/
    public function guestcantdelete(){

        $data= Ad::factory()->create()->toArray();

        $response=$this->deleteJson("/api/ad/del/${data['id']}");

        $response->assertStatus(401);

    }

}
