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
    /** @test  */
    public function UserCanBuyMaxPlanSuccessfully(){
        $user=User::factory(['wallet' => 100000])->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->getJson('/api/user/BuyPlan/4');
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['activePlan' => 'max' , 'AdsRemaining' => 45]);
    }
    /** @test  */
    public function GuestCantBuyPlan(){
        $user=User::factory(['wallet' => 25000])->create()->toArray();
        $response=$this->getJson('/api/user/BuyPlan/1');
        $response->assertStatus(401);
    }
    /** @test  */
    public function UserCantBuyInvalidPlanId(){
        $user=User::factory(['wallet' => 25000])->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->getJson('/api/user/BuyPlan/5');
        $response->assertStatus(400);
    }
}
