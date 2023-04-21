<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\bulletinProfesseurTypecompositonMatier>
 */
class BulletinProfesseurTypecompositonMatierFactory extends Factory
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
            "type_compo_id" =>rand(1,3),
            "bulletin_id"=>rand(1,10),
            "note"=>$this->faker->ean8,
            "avis" =>$this->faker->name(),
        ];
    }
}
