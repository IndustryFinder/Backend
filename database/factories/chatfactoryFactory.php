<?php

namespace Database\Factories;

use App\Models\chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class chatfactoryFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = chat::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender'=> User::factory(),
            'receiver'=> User::factory(),
            'massage'=> $this->faker->text(),

        ];
    }
}
