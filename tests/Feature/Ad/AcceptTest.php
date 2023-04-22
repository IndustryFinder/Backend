<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcceptTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function AssignReceiverForAd()
    {
        $data= Ad::factory()->make()->toArray();
        $response = $this->postJson('/ad/show',$data);
        $response->assertStatus(200);
    }
}
