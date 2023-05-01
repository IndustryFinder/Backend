<?php

namespace Tests\Feature\comment;

use App\Models\Comment;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetByCompanyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function AllCommentOfTheCompany()
    {
        $data= Comment::factory(['company_id'=>1])->count(5)->create()->toArray();
        $company=Company::factory(['id'=>1])->create()->toArray();
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->getJson("/api/Comment/GetByCompany/${company['id']}");
        $response->assertStatus(200);
    }
}
