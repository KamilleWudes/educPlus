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
        Schema::create('niveau_scolaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations 2023_02_17_161718_create_niveau_scolaires_table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('niveau_scolaires');
    }
};
