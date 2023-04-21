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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            // $table->string('nom')->unique();
            $table->string('nom');
            $table->foreignId("ecole_id")->constrained("ecoles");
            $table->foreignId("niveau_scolaires_id")->constrained("niveau_scolaires");
            $table->timestamps();

           $table->unique(["nom","ecole_id","niveau_scolaires_id"]);


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
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(["niveau_scolaires_id","ecole_id"]);
        });
        Schema::dropIfExists('classes');
    }
};
