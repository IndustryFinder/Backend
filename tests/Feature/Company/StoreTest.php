<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function AddNewCompany()
    {
        $data=Company::factory(['name'=>'parscompany'])->create()->toArray();
        $owner=User::factory(['role'=>'user'])->create();
        $this->actingAs(User::find($owner['id']));
        $response = $this->postJson('/api/company/add',$data);
        $response->assertStatus(201);
    }
    /** @test */
    public function GuestCantAddNewCompany()
    {
        $data=Company::factory(['name'=>'parscompany'])->create()->toArray();
        $response = $this->postJson('/api/company/add',$data);
        $response->assertStatus(401);
    }
    /** @test */
    public function UserCanOnlyOwnOneCompany()
    {
        $data=Company::factory(['name'=>'parscompany'])->make()->toArray();
        $owner=User::factory(['role'=>'company'])->create();
        $this->actingAs(User::find($owner['id']));
        $response = $this->postJson('/api/company/add',$data);
        $response->assertStatus(401);
    }

}
