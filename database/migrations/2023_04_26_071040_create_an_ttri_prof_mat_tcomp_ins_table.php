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
        Schema::create('an_ttri_prof_mat_tcomp_ins', function (Blueprint $table) {
            $table->foreignId("type_compo_id")->constrained("type_compositions");
            $table->foreignId("professeur_id")->constrained("professeurs");
            $table->foreignId("classe_id")->constrained("classes");
            $table->foreignId("matier_id")->constrained("matiers");
            $table->foreignId("annee_scolaire_id")->constrained("annee_scolaires");
            $table->foreignId("inscription_id")->constrained("inscriptions");
            $table->foreignId("type_trimestre_id")->constrained("type_trimestres");
            $table->integer('note');
            $table->timestamps();
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
        Schema::table('an_ttri_prof_mat_tcomp_ins', function (Blueprint $table) {

            $table->dropForeign(["type_compo_id","professeur_id","classe_id","matier_id","bulletin_id","annee_scolaire_id","inscription_id","type_trimestre_id"]);

        });
        Schema::dropIfExists('an_ttri_prof_mat_tcomp_ins');
    }
};
