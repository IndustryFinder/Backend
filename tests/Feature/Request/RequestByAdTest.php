<?php

namespace Tests\Feature\Request;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestByAdTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function testRequestsByAdWithRequests()
    {
        $ad = Ad::factory()->create();
        $requests = Request::factory()->count(3)->create(['ad_id' => $ad->id]);

        // Attach companies to the requests
        foreach ($requests as $request) {
            $company = Company::factory()->create();
            $request->company_id = $company->id;
            $request->save();
        }
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));

        $response = $this->getJson('/api/Request/GetByAd/' . $ad->id);

        $response->assertStatus(200);
        $response->assertJson($requests->toArray());
    }

    /** @test  */
    public function testRequestsByAdWithNoRequests(){
        $ad = Ad::factory()->create();
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));

        $response = $this->getJson('/api/Request/GetByAd/' . $ad->id);

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /** @test  */
    public function testRequestsByAdWithNonexistentAd(){
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));

        $response = $this->getJson('/api/Request/GetByAd/9999');
        $response->assertStatus(404);
    }

    /** @test  */
    public function testGuestCantRequest(){
        $ad = Ad::factory()->create();
        $response = $this->getJson('/api/Request/GetByAd/' . $ad->id);
        $response->assertStatus(401);
    }
}
