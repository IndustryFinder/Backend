<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Company;
use App\Models\User;
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
            'sender'=>User::factory(),
            'receiver'=>Company::factory(),
            'isCompany'=>$this->faker->boolean,
            'description'=>$this->faker->text(),
            'category_id'=>Category::factory(),
            'is_active'=>$this->faker->boolean,
            'ViewCount'=>$this->faker->randomNumber()
        ];
    }
}
