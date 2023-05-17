<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function UpdateUserInfo()
    {
        $data=User::factory()->create()->toArray();
        $this->actingAs(User::find($data['id']));
        $newdata=['phone'=>'0912'];
        $response = $this->postJson('/api/user/update',$newdata);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',$newdata);
    }
    /** @test */
    public function GuestCantUpdateUserInfo()
    {
        $data=User::factory()->create()->toArray();
        $newdata=['phone'=>'0912'];
        $response = $this->postJson('/api/user/update',$newdata);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',$data);
    }
}
