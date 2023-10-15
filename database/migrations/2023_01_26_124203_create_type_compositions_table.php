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
        Schema::create('type_compositions', function (Blueprint $table) {
            // $table->id();
            // $table->string('nom')->unique();
            // $table->foreignId("ecole_id")->constrained("ecoles");
            // $table->timestamps();
            // $table->unique(["nom","ecole_id"]);
            $table->id();
            $table->string('nom');
            $table->unsignedBigInteger('ecole_id');

           // $table->string('nom_ecole'); // Champ pour stocker le nom de l'école

            $table->foreign('ecole_id')->references('id')->on('ecoles')->onDelete('cascade');
            $table->unique(['nom', 'ecole_id']); // Contrainte d'unicité sur annee et nom_ecole
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
        Schema::table('type_compositions', function (Blueprint $table) {
            $table->dropForeign(["ecole_id"]);
        });
        Schema::dropIfExists('type_compositions');
    }
};
