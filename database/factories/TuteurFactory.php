<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tuteur>
 */
class TuteurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'noms' => $this->faker->lastName(),
            "prenoms" =>$this->faker->FirstName,
            "sex" => array_rand (["M","F"],1),
            'adresses'=>$this->faker->address,
            'emails' => $this->faker->unique()->safeEmail(),
            "telephone1" =>$this->faker->phoneNumber,
            "telephone2" =>$this->faker->phoneNumber,
        ];
    }
}
