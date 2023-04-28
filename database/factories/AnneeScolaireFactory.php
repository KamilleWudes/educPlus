<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\anneeScolaire>
 */
class AnneeScolaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           // "anneeScolaire" =>$this->faker->uuid,
            "annee1" =>$this->faker->ean8,
            "annee2" =>$this->faker->ean8,
            "ecole_id" =>rand(1,10),

        ];
    }
}
