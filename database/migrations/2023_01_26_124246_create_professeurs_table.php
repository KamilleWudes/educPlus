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
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->char('sexe');
            $table->string('adresse');
            $table->string('matricule')->nullable();
            $table->string('telephone1')->unique();
            $table->string("image");
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId("ecole_id")->constrained("ecoles");
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->string('role');

        //    $table->unique(["nom","prenom"]);

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
        Schema::table('professeurs', function (Blueprint $table) {
            $table->dropForeign(["ecole_id"]);
        });
        Schema::dropIfExists('professeurs');
    }
};
