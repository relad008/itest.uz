<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_questions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('creator_id');
            // from Categories
            $table->integer('category_id');
            $table->integer('journal_id');

            $table->text('description');

            $table->string('A',1000);
            $table->string('B',1000);
            $table->string('C',1000);
            $table->string('D',1000);

            $table->enum('correct_answer',['-','A','B','C','D']);
            $table->integer('text_id');
            $table->string('parents',100);
            $table->index('parents');
            $table->integer('theme_id');
            $table->string('t_parents');
            $table->enum('lang', Config::get('app.available_language'))->default('uz');
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
        Schema::drop('journal_questions');
    }
}
