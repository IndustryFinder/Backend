<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexByReceiverTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ShowReceiversAd()
    {
        $data= Ad::factory()->create()->toArray();
        $this->actingAs(User::find($data['sender']));
        $response = $this->getJson('/api/ad/searchByReceiver');
        $response->assertStatus(200);
    }
    /**@test*/
    public function GuestCantSeeReceivedAds()
    {
        $data= Ad::factory()->create()->toArray();
        $response = $this->getJson('/api/ad/searchByReceiver');
        $response->assertStatus(401);
    }
}
