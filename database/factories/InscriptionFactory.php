<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\inscription>
 */
class InscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "date_insription" =>$this->faker->date($format = 'Y-m-d', $max = 'now'),
            "etudiant_id" =>rand(1,10),
            "tuteur_id" =>rand(1,10),
            "classe_id" =>rand(1,10),
            "annee_scolaire_id" =>rand(1,2),

        ];
    }
}
