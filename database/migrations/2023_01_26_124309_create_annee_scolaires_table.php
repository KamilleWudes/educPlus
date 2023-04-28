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
            //$table->string('anneeScolaire');
            $table->string('annee1')->unique();
            $table->string('annee2')->unique();
            $table->foreignId("ecole_id")->constrained("ecoles");

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
