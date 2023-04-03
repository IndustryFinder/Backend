<?php

namespace Database\Factories;


use App\Models\Company;
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
            'name'=> $this->faker->name,
            'logo'=> $this->faker->string,
            'phone'=> $this->faker->string,
            'category_id'=> $this->faker->integer,
            'description'=> $this->faker->text(),
            'email' => $this->faker->unique()->safeEmail,
            'website'=> $this->faker->string,
            'user_id'=> $this->faker->integer,
            'is_active'=> $this->faker->boolean,
            'is_verified'=> $this->faker->boolean,
            'verification_file'=> $this->faker->string,
            'ViewCount'=> $this->faker->integer
        ];
    }
}
