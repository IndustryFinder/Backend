<?php

namespace Tests\Feature\Ad;

use App\Models\Ad;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AcceptTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function AssignReceiverForAd()
    {
        $data= Ad::factory(['receiver'=>null])->create()->toArray();
        $companny=Company::factory()->create();
        $this->actingAs(User::find($data['sender']));
        $response = $this->postJson('/api/ad/accept',['receiver'=>$companny->id ,'ad_id' =>$data['id']]);
        $response->assertStatus(201);
    }
    /** @test */
    public function OnlySenderOfAdCanAccept()
    {
        $data= Ad::factory()->create()->toArray();
        $companny=Company::factory()->create();
        $response = $this->postJson('/api/ad/accept',['receiver'=>$companny->id,'ad_id' =>$data['id']]);
        $response->assertStatus(401);
    }

}
