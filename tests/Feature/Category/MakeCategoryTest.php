<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MakeCategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function AddNewCategory()
    {
        Storage::fake('photo');
        $file = \Illuminate\Http\UploadedFile::fake()->image('644fffada0270.png');
        $data=Category::factory(['photo'=>$file])->create()->toArray();
        $user=User::factory()->create()->toArray();
        $this->actingAs(User::find($user['id']));
        $response = $this->postJson("/api/Category/makeCategory",$data);
        $response->assertStatus(201);
    }
}
