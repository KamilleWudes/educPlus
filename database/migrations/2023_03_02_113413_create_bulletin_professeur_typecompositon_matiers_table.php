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
        Schema::create('bulletin_professeur_typecompositon_matiers', function (Blueprint $table) {
            $table->foreignId("type_compo_id")->constrained("type_compositions");
            $table->foreignId("professeur_id")->constrained("professeurs");
            $table->foreignId("matier_id")->constrained("matiers");
            $table->foreignId("bulletin_id")->constrained("bulletins");
            $table->integer('note');
            $table->string('avis');
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
        Schema::table('bulletin_professeur_typecompositon_matiers', function (Blueprint $table) {

            $table->dropForeign(["type_compo_id","professeur_id","matier_id","bulletin_id"]);

        });
        Schema::dropIfExists('bulletin_professeur_typecompositon_matiers');
    }
};
