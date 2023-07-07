<?php

namespace Tests\Feature\comment;

use App\Models\Comment;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AvgRatingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function testAvgRatingWithComments()
    {
        $comments = Comment::factory(['company_id'=>100])
            ->count(5)
            ->state(function () {
                return [
                    'rating' => rand(1, 5), // Set a random rating between 1 and 5
                ];
            })
            ->create();

        // Calculate the average rating manually
        $totalRating = 0;
        foreach ($comments as $comment) {
            $totalRating += $comment->rating;
        }
        $expectedAvgRating = $totalRating / $comments->count();

        // Test the response structure and data
        $response = $this->getJson("/api/Comment/getAvgRate/100");
        $response->assertStatus(200);
        $response->assertJson(['avg' => $expectedAvgRating]);
    }
    /** @test */
    public function testAvgRatingWithNoComments()
    {
        $response = $this->getJson("/api/Comment/getAvgRate/1000");
        $response->assertStatus(200);
        $response->assertJson(['avg' => 0]);
    }
}
