<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->lastName(),
            "prenom" =>$this->faker->FirstName,
            "sexe" => array_rand (["M","F"],1),
            "dateNaissance" =>$this->faker->date($format = 'Y-m-d', $max = 'now'),
            "LieuNaissance"=>$this->faker->city,
            'adresse'=>$this->faker->address,
            "telephone" =>$this->faker->phoneNumber,
            "image" =>"",
            'email' => $this->faker->unique()->safeEmail(),
            "matricule" =>$this->faker->name(),



        ];

    }
}
