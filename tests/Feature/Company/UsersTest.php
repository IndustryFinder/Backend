<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function AllUsersOfTheCompany()
    {
        $data=Company::factory()->create()->toArray();
        dd($data);
        $response = $this->getJson("/api/company/user",['id'=>$data['id']]);
        $response->assertStatus(200);

    }
}
