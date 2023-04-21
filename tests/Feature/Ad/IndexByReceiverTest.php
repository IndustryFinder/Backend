<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class indexByReceiverTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ShowReceiversAd()
    {
        $data= Ad::factory()->make()->toArray();
        $response = $this->getJson('/ad/searchByReceiver',$data['receiver']);
        $response->assertStatus(200);
    }
}
