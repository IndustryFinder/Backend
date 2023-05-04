<?php

namespace Database\Factories;


use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->word,
            'phone'=> $this->faker->phoneNumber,
            'category_id'=> Category::factory(),
            'description'=> $this->faker->text(),
            'email' => $this->faker->unique()->email,
            'website'=> $this->faker->url,
            'user_id'=> User::factory(),
            'is_active'=> $this->faker->boolean,
            'is_verified'=> $this->faker->boolean,
            'ViewCount'=> $this->faker->randomNumber()
        ];
    }
}
