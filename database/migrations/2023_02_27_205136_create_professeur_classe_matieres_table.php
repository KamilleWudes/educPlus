<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professeur_classe_matieres', function (Blueprint $table) {
            $table->id();

            $table->foreignId("classe_id")->constrained("classes");
            $table->foreignId("matier_id")->constrained("matiers");
            $table->foreignId("professeur_id")->constrained("professeurs");
            $table->foreignId("ecole_id")->constrained("ecoles");
            $table->foreignId("annee_scolaire_id")->constrained("annee_scolaires");


            $table->timestamps();

          // $table->unique(["classe_id","matier_id","professeur_id"]);
         // $table->unique(['professeur_id', 'classe_id', 'matier_id'], 'uc_prof_classe_matiere_ecole');


        });
        schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professeur_classe_matieres', function (Blueprint $table) {

            $table->dropForeign(["classe_id","matier_id","professeur_id","ecole_id","annee_scolaire_id"]);

        });
         Schema::dropIfExists('professeur_classe_matieres');
       // $table->dropUnique('uc_prof_classe_matiere_ecole');

    }
};
