<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('challenger_id');
            $table->unsignedInteger('challenged_id');
            $table->boolean('accepted')->default(false);
            $table->timestamps();

            $table->foreign('challenger_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('challenged_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenge_user');
    }
}
