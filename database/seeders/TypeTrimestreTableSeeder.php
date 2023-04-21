<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTrimestreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("type_trimestres")->Insert([
            ["nom"=>"Premier Trimestre"],
            ["nom"=>"Deuxième Trimestre"],
            ["nom"=>"Troisième Trimestre"]
         ]);
    }
}
