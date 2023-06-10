<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use App\Models\User;
use Carbon\Carbon;
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
    public function MakeNewAdWithNoActivePlan()
    {
        $data= Ad::factory(['title'=>'NewAd'])->create()->toArray();
        $user = User::find($data['sender']);
        $this->actingAs($user);
        $response=$this->postJson('/api/ad/makeAd',$data);
        $response->assertStatus(402);
    }

    /** @test  */
    public function MakeNewAdSuccessfully(){
        $data= Ad::factory(['title'=>'NewAd'])->create()->toArray();
        $user = User::find($data['sender']);
        $this->actingAs($user);
        $user['AdsRemaining'] = 1;
        $user['PlanExpireDate'] = Carbon::now()->addDays(1);
        $user->save();
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
