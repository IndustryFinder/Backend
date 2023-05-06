<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddCashTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function UserAddCashSuccessfully()
    {
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $user['cash'] = 1000;
        $response=$this->postJson('/api/user/Addcash', $user);
        $response->assertStatus(200);
    }
    /** @test  */
    public function GuestCantAddCash(){
        $user=User::factory()->create()->toArray();
        $user['cash'] = 1000;
        $response=$this->postJson('/api/user/Addcash', $user);
        $response->assertStatus(401);
    }
    /** @test  */
    public function CantChargeNegativeAmount(){
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $user['cash'] = -1;
        $response=$this->postJson('/api/user/Addcash', $user);
        $response->assertStatus(422);
    }
}
