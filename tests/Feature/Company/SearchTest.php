<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function GetAllCompany()
    {
        $data=Company::factory()->count(5)->create()->toArray();
        $response=$this->postJson("/api/company/search");
        $response->assertStatus(200);
    }
    /** @test  */
    public function FindCompanyByTitle(){
        $data=Company::factory(['name'=>'pars'])->count(5)->create()->toArray();
        $response=$this->postJson("/api/company/search",['name'=>$data[1]['name']]);
        $response->assertStatus(200);
    }
    /** @test  */
    public function FindCompanyByCategory(){
        $data=Company::factory(['category_id'=>'1'])->count(5)->create()->toArray();
        $response=$this->postJson("/api/company/search",['category_id'=>$data[1]['category_id']]);
        $response->assertStatus(200);
    }
}
