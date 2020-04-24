<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description_short','1000');
            $table->string('video_url');
            $table->enum('lang',Config::get('app.available_language'));
            $table->integer('theme_id')->unsigned();
            $table->text('description');
            $table->integer('total_question')->unsigned();
            $table->integer('index')->unsigned();
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
        Schema::drop('lectures');
    }
}
