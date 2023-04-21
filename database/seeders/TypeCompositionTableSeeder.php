<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeCompositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("type_compositions")->Insert([
            ["nom"=>"Premier composition"],
            ["nom"=>"Deuxième composition"],
            ["nom"=>"Troisième composition"]
         ]);
    }
}
