<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function UserCanSignUpSuccessfully()
    {
        $user = User::factory()->make()->toArray();
        $user['password_confirmation'] = $user['password'] = '12345678';
        $response = $this->postJson('/api/user/signup', $user);

        $response->assertCreated();
        $this->assertDatabaseHas('users',['name' => $user['name'] , 'email' => $user['email']]);
    }

    /** @test */
    public function UserCantUseRepeatedEmail()
    {
        $user2 = User::factory()->create();
        $user1 = User::factory(['email'=> $user2->email ])->make()->toArray();
        $user1['password_confirmation'] = $user1['password'] = '12345678';
        $response = $this->postJson('/api/user/signup', $user1);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('users',['name' => $user1['name'] , 'email' => $user1['email']]);
    }
}
