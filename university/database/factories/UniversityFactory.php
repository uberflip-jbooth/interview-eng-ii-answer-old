<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Domain;
use App\Models\WebPage;

class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'alpha_two_code' => $this->faker->countryCode(),
            'country' => $this->faker->country(),
            'state-province' => $this->faker->state(),
            'name' => $this->faker->company(),
        ];
    }
}
