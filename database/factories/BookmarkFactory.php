<?php

namespace Database\Factories;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookmarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookmark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> $this->faker->integer,
            'marked_id'=> $this->faker->integer
        ];
    }
}
