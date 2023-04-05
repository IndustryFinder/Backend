<?php

namespace Tests\Feature\models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Request;


class RequestTest extends TestCase
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
        $data= Request::factory()->make()->toArray();
        Request::create($data);
        $this->assertDatabaseHas('requests', $data);
    }
}
