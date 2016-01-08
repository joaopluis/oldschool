<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description', 600);
            $table->string('video_url');
            $table->text('text_content');
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->integer('course_id')->index();
            $table->integer('order')->default(99);
        });

        Schema::create('recommendations', function(Blueprint $table){
            $table->integer('parent_id')->unsigned()->index();
            $table->foreign('parent_id')->references('id')->on('lessons')->onDelete('cascade');

            $table->integer('child_id')->unsigned()->index();
            $table->foreign('child_id')->references('id')->on('lessons')->onDelete('cascade');
        });

        Schema::create('lesson_user', function(Blueprint $table){
            $table->integer('lesson_id')->unsigned()->index();
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lessons');
        Schema::drop('recommendations');
        Schema::drop('lesson_user');
    }
}
