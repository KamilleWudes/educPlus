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
        Schema::create('matiers', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->foreignId("ecole_id")->constrained("ecoles");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matiers', function (Blueprint $table) {
            $table->dropForeign(["ecole_id"]);
        });
        Schema::dropIfExists('matiers');
    }
};
