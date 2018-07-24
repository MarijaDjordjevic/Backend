<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('player_x');
            $table->unsignedInteger('player_o');
            $table->integer('winner')->nullable();
            $table->boolean('draw')->default(false);
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('player_x')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('player_o')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
