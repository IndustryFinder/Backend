<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test*/
    public function testLogoutSuccessfully()
    {
        $user = User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response = $this->getJson('/api/authentication/logout');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logged Out']);
    }

    /** @test*/
    public function testGuestCantLogout()
    {
        $response = $this->getJson('/api/authentication/logout');
        $response->assertStatus(401);
    }
}
