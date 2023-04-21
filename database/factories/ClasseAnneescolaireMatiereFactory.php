<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClasseAnneescolaireMatiere>
 */
class ClasseAnneescolaireMatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "classe_id" =>rand(1,10),
            "matier_id"=>rand(1,10),
            "annee_scolaire_id" =>rand(1,2),
            "coefficient"=>$this->faker->ean8,
        ];
    }
}
