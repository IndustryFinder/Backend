<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test*/
    public function UserCanLoginSuccessfully()
    {
        $user = User::factory()->create()->toArray();
        $response = $this->postJson('/api/user/login',['email' => $user['email'], 'password' => 'password']);
        $response->assertStatus(200);
    }

    /** @test*/
    public function UserCantLoginWithWrongPass()
    {
        $response = $this->postJson('/api/user/login',['email' => 'a@b.c', 'password' => 'password']);
        $response->assertStatus(401);
    }
}
