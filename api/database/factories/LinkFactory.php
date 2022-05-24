<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'inputUrl'        => $this->faker->unique()->url(),
            'hashKey'         => $this->faker->unique()->randomNumber(5),
            'baseUrl'         => 'http://127.0.0.1:8000'
        ];
    }
}
