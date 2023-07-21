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
        Schema::create('annee_scolaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ecole_id');
            //$table->string('anneeScolaire');
            $table->string('annee1');
            $table->string('annee2');
            $table->string('nom_ecole'); // Champ pour stocker le nom de l'école

           // $table->foreignId("ecole_id")->constrained("ecoles");

            $table->foreign('ecole_id')->references('id')->on('ecoles')->onDelete('cascade');
            $table->unique(['annee1', 'nom_ecole']); // Contrainte d'unicité sur annee et nom_ecole



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
        Schema::table('annee_scolaires', function (Blueprint $table) {
            $table->dropForeign(["ecole_id"]);
        });
        Schema::dropIfExists('annee_scolaires');
    }
};
