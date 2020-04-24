<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLectureSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lecture_id')->unsigned();
            $table->string('theme_parents');
            $table->integer('user_id')->unsigned();
            $table->text('questions');
            $table->text('answers');
            $table->integer('total_questions');
            $table->integer('correct_answers_count')->unsigned();
            $table->integer('prev_correct_answers_count')->unsigned();
            // in sec
            $table->integer('time');
            $table->enum('completed',[0,1]);
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
        Schema::drop('lecture_sessions');
    }
}
