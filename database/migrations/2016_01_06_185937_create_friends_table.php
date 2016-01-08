<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user1_id')->unsigned()->index();
            $table->foreign('user1_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user2_id')->unsigned()->index();
            $table->foreign('user2_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('companion')->default(false);
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
        Schema::drop('friends');
    }
}
