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
        Schema::create('ecoles', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('adresse');
            $table->string('telephone1')->unique();
            $table->string('telephone2')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("image")->nullable();

            // $table->foreignId("niveau_scolaires_id")->constrained("niveau_scolaires");

            $table->timestamps();
        });
       // schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('ecoles', function (Blueprint $table) {
        //     $table->dropForeign(["niveau_scolaires_id"]);
        // });
        Schema::dropIfExists('ecoles');
    }
};
