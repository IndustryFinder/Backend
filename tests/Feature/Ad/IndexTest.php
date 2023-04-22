<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ShowAds()
    {
        $data= Ad::factory()->make()->toArray();
        $response = $this->getJson('/ad/search',$data);
        $response->assertStatus(200);
    }
}
