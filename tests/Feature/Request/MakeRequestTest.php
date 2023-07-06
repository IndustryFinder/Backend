<?php

namespace Tests\Feature\Request;

use App\Models\Company;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MakeRequestTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function MakeRequestSuccessfully()
    {
        $data= Request::factory()->make()->toArray();
        $company = Company::find($data['company_id']);
        $this->actingAs(User::find($company['user_id']));
        $response=$this->postJson('/api/request/add',$data);
        $response->assertCreated();
        $this->assertDatabaseHas('requests',['message' => $data['message'] , 'ad_id' => $data['ad_id'] , 'company_id' => $data['company_id']]);
    }

    /** @test  */
    public function GuestCantMakeRequest(){
        $data= Request::factory()->make()->toArray();
        $response=$this->postJson('/api/request/add',$data);
        $response->assertStatus(401);
        $this->assertDatabaseMissing('requests',['message' => $data['message'] , 'ad_id' => $data['ad_id'] , 'company_id' => $data['company_id']]);
    }
}
