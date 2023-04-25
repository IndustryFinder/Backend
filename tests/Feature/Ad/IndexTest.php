<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function Index()
    {
        $data= Ad::factory()->create()->toArray();
        $response = $this->postJson('/api/ad/search',$data);
        $response->assertStatus(200);
    }
}
