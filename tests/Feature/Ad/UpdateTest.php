<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function UpdateAd()
    {
        $data=Ad::factory()->create()->toArray();
        $newdata=['title'=>'iphone 14'];
        $this->actingAs(User::find($data['sender']));
        $response = $this->postjson("/api/ad/Update/${data['id']}",$newdata);
        $response->assertStatus(201);
        $this->assertDatabaseHas('ads',$newdata);

    }

    /** @test */
    public function GuestCantUpdateAd()
    {
        $data=Ad::factory()->create()->toArray();
        $newdata=['title'=>'iphone 14'];
        $response = $this->postjson("/api/ad/Update/${data['id']}",$newdata);
        $response->assertStatus(401);
        $this->assertDatabaseHas('ads',$data);

    }

}
