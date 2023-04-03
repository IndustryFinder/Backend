<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Request::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ad_id'=>  $this->faker->integer,
            'company_id'=>  $this->faker->integer,
            'status'=>new sequence('pending','accepted','rejected'),
            'message'=>$this->faker->text()
        ];
    }
}
