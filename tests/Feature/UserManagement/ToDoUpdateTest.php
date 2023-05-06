<?php

namespace Tests\Feature\UserManagement;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToDoUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function UpdateTodoSuccessfully()
    {
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $user['todo'] = 'Todo Test';
        $response=$this->postJson('/api/user/Todoupdate',$user);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users',['todo' => $user['todo']]);
    }
    /** @test  */
    public function GuestCantUpdateTodoList(){

        $user=User::factory()->create()->toArray();
        $user['todo'] = 'Todo Test';
        $response=$this->postJson('/api/user/Todoupdate',$user);
        $response->assertStatus(401);
    }
}
