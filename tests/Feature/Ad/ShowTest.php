<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ShowOneAdAndAddViewCount()
    {
        $data= Ad::factory()->create()->toArray();
        $response = $this->getJson("/api/ad/show/${data['id']}");
        $response->assertStatus(200);
    }
}
