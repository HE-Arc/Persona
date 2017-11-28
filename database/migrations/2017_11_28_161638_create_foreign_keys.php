<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * C'est une méthode douteuse je vous l'accorde,
     * mais si vous voyez ça, c'est que ça marche...
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL');
            $table->foreign('personality_id')->references('id')->on('personalities')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
