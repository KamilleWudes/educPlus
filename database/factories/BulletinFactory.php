<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\bulletin>
 */
class BulletinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "date_bulletin" =>$this->faker->date($format = 'Y-m-d', $max = 'now'),
            "inscription_id" =>rand(1,10),
            "type_trimestre_id" =>rand(1,3),
            "annee_scolaire_id" =>rand(1,2)
        ];
    }
}
