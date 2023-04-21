<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TypeCompositionTableSeeder::class);
        $this->call(TypeTrimestreTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(niveauScolaireTableSeeder::class);

        \App\Models\Ecole::factory(10)->create();
         \App\Models\User::factory(10)->create();
         \App\Models\Etudiant::factory(10)->create();
         \App\Models\Tuteur::factory(10)->create();
         \App\Models\Matier::factory(10)->create();
         \App\Models\userprincipal::factory(5)->create();

        //  \App\Models\niveauScolaires::factory(3)->create();
         \App\Models\Professeur::factory(10)->create();
         \App\Models\anneeScolaire::factory(2)->create();
         \App\Models\classe::factory(10)->create();
          \App\Models\inscription::factory(10)->create();
          \App\Models\bulletin::factory(10)->create();
          \App\Models\ProfesseurClasseMatiere::factory(10)->create();
          \App\Models\ClasseAnneescolaireMatiere::factory(10)->create();
          \App\Models\bulletinProfesseurTypecompositonMatier::factory(10)->create();








        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
