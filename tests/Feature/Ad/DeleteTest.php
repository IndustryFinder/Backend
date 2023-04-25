<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function DeleteAd()
    {
        $data= Ad::factory()->make()->toArray();
        $this->actingAs(User::find($data['sender']));
        $response=$this->deleteJson('/ad/del/{ad}',$data);
        $response->assertStatus(200);
    }

    /**@test*/
    public function guestcantdelete(){

        $data= Ad::factory()->make()->toArray();
        $response=$this->deleteJson('/ad/del/{ad}',$data);

        $response->assertStatus(401);

    }

}
