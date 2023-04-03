<?php

namespace Tests\Feature\models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use refreshDarabase;
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function insertdata()
    {
       $data= user::factory()->make()->toArray();
       user::create($data);
        $this->assertDatabaseHas('users', $data);
    }
}
