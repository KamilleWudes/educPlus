<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class niveauScolaireTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("niveau_scolaires")->Insert([
            ["nom"=>"Primaire"],
            ["nom"=>"Collège"],
            ["nom"=>"Lycée"]
         ]);
    }
}
?>
