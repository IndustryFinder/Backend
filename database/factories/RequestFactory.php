<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Request;
use Doctrine\DBAL\Schema\Sequence;
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
            'ad_id'=>  Ad::factory(),
            'company_id'=>  Company::factory(),
            'message'=>$this->faker->text()
        ];
    }
}
