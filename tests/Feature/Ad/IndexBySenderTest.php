<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexBySenderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ShowSendersAds()
    {
        $data= Ad::factory()->create()->toArray();
        $this->actingAs(User::find($data['sender']));
        $response = $this->getJson('/api/ad/searchBySender');
        $response->assertStatus(200);
    }
    /** @test */
    public function GuestCantSeeTheirAds()
    {
        $data= Ad::factory()->create()->toArray();
        $response = $this->getJson('/api/ad/searchBySender');
        $response->assertStatus(401);
    }
}
