<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->increments('id');
            // NOTE : L'idéal serait une clé primaire ou au moins d'unicité sur un regroupement des deux clés étrangères
            $table->integer('requester_id')->index()->unsigned();
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('requested_id')->index()->unsigned();
            $table->foreign('requested_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->boolean('friendship')->default(false);
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
        Schema::dropIfExists('friend_requests');
    }
}
