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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->date("date_insription");
            $table->foreignId("etudiant_id")->constrained("etudiants");
            $table->foreignId("tuteur_id")->constrained("tuteurs");
            $table->foreignId("classe_id")->constrained("classes");
            $table->foreignId("annee_scolaire_id")->constrained("annee_scolaires");
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
    {      Schema::table('inscriptions', function (Blueprint $table) {
        $table->dropForeign(["etudiant_id","tuteur_id","classe_id","annee_scolaire_id"]);
    });
        Schema::dropIfExists('inscriptions');
    }
};
