<?php

namespace Tests\Feature\Request;

use App\Models\Company;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyRequestTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function DestroyRequestSuccessfully()
    {
        $data= Request::factory()->create()->toArray();
        $company = Company::find($data['company_id']);
        $this->actingAs(User::find($company['user_id']));
        $response=$this->deleteJson("/api/request/del/${data['id']}");
        $response->assertStatus(201);
        $this->assertDatabaseMissing('requests',['message' => $data['message'] , 'ad_id' => $data['ad_id'] , 'company_id' => $data['company_id']]);
    }

    /** @test  */
    public function CantDestroyInvalidRequest(){
        $data= Request::factory()->create()->toArray();
        $response=$this->deleteJson('/api/request/del/0');
        $response->assertStatus(401);
    }

    /** @test  */
    public function GuestCantDestroyRequest(){
        $data= Request::factory()->create()->toArray();
        $response=$this->deleteJson("/api/request/del/${data['id']}");
        $response->assertStatus(401);
    }
}
