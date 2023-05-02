<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\an_ttri_prof_mat_tcomp_in>
 */
class an_ttri_prof_mat_tcomp_inFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "professeur_id" =>rand(1,10),
            "matier_id"=>rand(1,10),
            "classe_id"=>rand(1,10),
            "type_compo_id" =>rand(1,3),
            //"note"=>$this->faker->ean8,
            "note"=>$this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 20),
            "inscription_id" =>rand(1,10),
            "type_trimestre_id" =>rand(1,3),
            "annee_scolaire_id" =>rand(1,2)

            //$note = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 20);

        ];
    }
}
