<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetBalanceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function GetBalanceSuccessfully()
    {
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->postJson('/api/user/GetBalance');
        $response->assertStatus(200);
    }
    /** @test  */
    public function GuestCantGetBalance(){
        $response=$this->postJson('/api/user/GetBalance');
        $response->assertStatus(401);
    }
}
