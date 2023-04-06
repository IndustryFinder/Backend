<?php

namespace Tests\Feature\models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Bookmark;


class BookmarkTest extends TestCase
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
        $data= Bookmark::factory()->make()->toArray();
        Bookmark::create($data);
        $this->assertDatabaseHas('bookmarks', $data);
    }
}
