<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('alias')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('country_id')->index()->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL');
            $table->integer('personality_id')->index()->unsigned()->nullable();
            $table->foreign('personality_id')->references('id')->on('personalities')->onDelete('SET NULL');
            //$table->string('description');
            $table->char('gender', 1);
            $table->date('birthday');
            //$table->string('profileimage');
            //$table->boolean('onlinestatus')->default(0);
            //$table->boolean('chatstatus')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
