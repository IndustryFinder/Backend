<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ButPlanTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function UserCanBuyClassicPlanSuccessfully()
    {
        $user=User::factory(['wallet' => 25000])->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->getJson('/api/user/BuyPlan/1');
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['activePlan' => 'classic' , 'AdsRemaining' => 10]);
    }
    /** @test  */
    public function UserCanBuyProPlanSuccessfully(){
        $user=User::factory(['wallet' => 50000])->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->getJson('/api/user/BuyPlan/2');
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['activePlan' => 'pro' , 'AdsRemaining' => 15]);
    }
    /** @test  */
    public function UserCanBuyDeluxePlanSuccessfully(){
        $user=User::factory(['wallet' => 75000])->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->getJson('/api/user/BuyPlan/3');
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['activePlan' => 'deluxe' , 'AdsRemaining' => 30]);
    }
}
