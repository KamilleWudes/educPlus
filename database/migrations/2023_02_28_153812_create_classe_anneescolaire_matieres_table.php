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
        Schema::create('classe_anneescolaire_matieres', function (Blueprint $table) {
            $table->foreignId("classe_id")->constrained("classes");
            $table->foreignId("matier_id")->constrained("matiers");
            $table->foreignId("annee_scolaire_id")->constrained("annee_scolaires");
            $table->integer('coefficient');

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
        Schema::table('classe_anneescolaire_matieres', function (Blueprint $table) {

            $table->dropForeign(["classe_id","matier_id","annee_scolaire_id"]);

        });
        Schema::dropIfExists('classe_anneescolaire_matieres');
    }
};
