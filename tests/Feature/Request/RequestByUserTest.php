<?php

namespace Tests\Feature\Request;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestByUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function testRequestsByUserWithAdsAndRequests()
    {
        $user = User::factory()->create();
        $ads = Ad::factory()->count(2)->create(['sender' => $user->id]);

        foreach ($ads as $ad) {
            $requests = Request::factory()->count(2)->create(['ad_id' => $ad->id]);

            foreach ($requests as $request) {
                $company = Company::factory()->create();
                $request->company_id = $company->id;
                $request->save();
            }
        }
        $this->actingAs(User::find($user['id']));
        // Send the request to get requests by user
        $response = $this->getJson('/api/Request/GetByUser/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson($ads->toArray());
    }

    /** @test  */
    public function testRequestsByUserWithNoAds(){
        $user = User::factory()->create();
        $this->actingAs(User::find($user['id']));
        // Send the request to get requests by user
        $response = $this->getJson('/api/Request/GetByUser/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /** @test  */
    public function testRequestsByUserWithNonexistentUser(){
        $user = User::factory()->create();
        $this->actingAs(User::find($user['id']));
        $response = $this->getJson('/api/Request/GetByUser/0');
        $response->assertStatus(404);
    }

    /** @test  */
    public function testGuestCantRequest(){
        $user = User::factory()->create();
        $response = $this->getJson('/api/Request/GetByUser/' . $user->id);
        $response->assertStatus(401);
    }
}
