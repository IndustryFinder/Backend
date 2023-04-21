<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ShowOneAdAndAddViewCount()
    {
        $data= Ad::factory()->make()->toArray();
        $response = $this->getJson('/ad/show',$data);
        $response->assertStatus(200);
    }
}
