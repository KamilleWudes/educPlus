<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ecole>
 */
class EcoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'adresse'=>$this->faker->address,
            "telephone1" =>$this->faker->phoneNumber,
            "telephone2" =>$this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail(),
            "image" =>"",
        ];
    }
}
