<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAchievements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->integer('num_lessons')->unsigned()->nullable();
            $table->integer('lesson_id')->unsigned()->nullable();
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('achievement_user', function (Blueprint $table) {
            $table->primary(['achievement_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropForeign('achievements_lesson_id_foreign');
            $table->dropColumn(['num_lessons', 'lesson_id']);
            $table->dropTimestamps();
        });

        Schema::table('achievement_user', function (Blueprint $table) {
            $table->dropPrimary('achievement_user_achievement_id_user_id_primary');
        });
    }
}
