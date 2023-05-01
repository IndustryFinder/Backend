<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MakeAdTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function MakeNewAd()
    {
        $data= Ad::factory()->create()->toArray();
        $this->actingAs(User::find($data['sender']));
        $response=$this->postJson('/api/ad/makeAd',$data);
        $response->assertStatus(201);
    }
    /** @test  */
   public function GuestCantMakeNewAd(){
       $data= Ad::factory()->create()->toArray();
       $response=$this->postJson('/api/ad/makeAd',$data);
       $response->assertStatus(401);
   }
}
