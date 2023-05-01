<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function DeleteCategory()
    {
        $data=Category::factory(['photo'=>'644fffada0270.png'])->create()->toArray();
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response=$this->deleteJson("/api/Category/del/${data['id']}");
        $response->assertStatus(200);
    }
}
