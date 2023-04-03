<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->title,
            'sender'=>$this->faker->integer,
            'receiver'=>$this->faker->integer,
            'isCompany'=>$this->faker->boolean,
            'description'=>$this->faker->text(),
            'category_id'=>$this->faker->integer,
            'max_budget'=>$this->faker->integer,
            'min_budget'=>$this->faker->integer,
            'is_active'=>$this->faker->boolean,
            'photo'=>$this->faker->string,
            'ViewCount'=>$this->faker->integer
        ];
    }
}
