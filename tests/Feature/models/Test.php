<?php

namespace Tests\Feature\models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function insertdata()
    {
       $data= user::factory()->raw();
       user::create($data);
        $this->assertDatabaseHas('users', ['name'=>$data['name']]);
    }
}
