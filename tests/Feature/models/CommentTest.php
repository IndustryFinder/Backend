<?php

namespace Tests\Feature\models;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Comment;


class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function insertdata()
    {
        $data= Comment::factory()->make()->toArray();
        Comment::create($data);
        $this->assertDatabaseHas('comments', $data);
    }


}
