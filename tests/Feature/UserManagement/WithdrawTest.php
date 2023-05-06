<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WithdrawTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function WithdrawFromWalletSuccessfully()
    {
        $user=User::factory(['wallet' => 5000])->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $user['cash'] = 1000;
        $response=$this->postJson('/api/user/Withdraw', $user);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['wallet' => 4000]);
    }
    /** @test  */
    public function CantWithdrawMoreThanWallet(){
        $user=User::factory(['wallet' => 1000])->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $user['cash'] = 5000;
        $response=$this->postJson('/api/user/Withdraw', $user);
        $response->assertStatus(400);
        $this->assertDatabaseHas('users',['wallet' => 1000]);
    }
    /** @test  */
    public function GuestCantWithdraw(){
        $user=User::factory()->create()->toArray();
        $user['cash'] = 1000;
        $response=$this->postJson('/api/user/Withdraw', $user);
        $response->assertStatus(401);
    }
}
