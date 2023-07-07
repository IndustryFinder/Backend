<?php

namespace Tests\Feature\Request;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestByCompanyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function testRequestsByCompanyWithRequests()
    {
        $company = Company::factory()->create();
        $requests = Request::factory()->count(3)->create(['company_id' => $company->id]);

        // Attach ads to the requests
        foreach ($requests as $request) {
            $ad = Ad::factory()->create();
            $request->ad_id = $ad->id;
            $request->save();
        }
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response = $this->getJson('/api/Request/GetByCompany/' . $company->id);

        // Test the response status code and data
        $response->assertStatus(200);
        $response->assertJson($requests->toArray());
    }

    /** @test  */
    public function testRequestsByCompanyWithNoRequests(){
        $company = Company::factory()->create();
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response = $this->getJson('/api/Request/GetByCompany/' . $company->id);
        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /** @test  */
    public function testRequestsByCompanyWithNonexistentCompany(){
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response = $this->getJson('/api/Request/GetByCompany/0');
        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /** @test  */
    public function testGuestCantRequest(){
        $company = Company::factory()->create();
        $response = $this->getJson('/api/Request/GetByCompany/' . $company->id);
        $response->assertStatus(401);
    }
}
