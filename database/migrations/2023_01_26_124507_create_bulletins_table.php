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
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();
            $table->date("date_bulletin");
            $table->foreignId("annee_scolaire_id")->constrained("annee_scolaires");
            $table->foreignId("inscription_id")->constrained("inscriptions");
            $table->foreignId("type_trimestre_id")->constrained("type_trimestres");
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
        Schema::table('bulletins', function (Blueprint $table) {
            $table->dropForeign(["annee_scolaire_id","inscription_id","type_trimestre_id"]);
        });
        Schema::dropIfExists('bulletins');
    }
};
