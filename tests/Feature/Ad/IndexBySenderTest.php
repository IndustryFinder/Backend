<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class indexBySenderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ShowSendersAds()
    {
        $data= Ad::factory()->make()->toArray();
        $response = $this->getJson('/ad/searchBySender',$data['Sender']);
        $response->assertStatus(200);
    }
}
