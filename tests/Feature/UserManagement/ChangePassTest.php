<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangePassTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ChangePassword()
    {
        $data=User::factory()->create()->toArray();
        $this->actingAs(User::find($data['id']));
        $newdata=['password'=>'qweasd'];
        $response = $this->postJson('/api/user/changepass',['new_password'=>$newdata,'password'=>$data['password']]);
        $response->assertStatus(200);
    }
    /** @test  */
    public function GuestCantChangePassword()
    {
        $data=User::factory()->create()->toArray();
        $newdata=['password'=>'qweasd'];
        $response = $this->postJson('/api/user/changepass',['new_password'=>$newdata,'password'=>$data['password']]);
        $response->assertStatus(401);
    }
}
