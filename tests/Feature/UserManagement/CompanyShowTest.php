<?php

namespace Tests\Feature\UserManagement;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function GetCompanyDetailsSuccessfully()
    {
        $company = Company::factory(['is_active' => true])->create()->toArray();
        $response = $this->getJson("/api/company/show/${company['id']}");
        $response
            ->assertStatus(200)
            ->assertJsonPath('name',$company['name']);
    }

    /** @test */
    public function UserCantGetDetailsOfInActiveCompany()
    {
        $company = Company::factory(['is_active' => false])->create()->toArray();
        $response = $this->getJson("/api/company/show/${company['id']}");
        $response->assertStatus(404);
    }

    /** @test */
    public function UserCantGetDetailsOfCompanyWithWrongId()
    {
        $response = $this->getJson("/api/company/show/0");
        $response->assertStatus(404);
    }
}
