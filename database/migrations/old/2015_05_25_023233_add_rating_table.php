<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ratings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('correct_1');
			$table->integer('correct_2');
			$table->integer('correct_3');
			$table->integer('subject_1_id');
			$table->integer('subject_2_id');
			$table->integer('subject_3_id');
			$table->float('total_balls');
			$table->enum('type',['thematic','direction']);
			$table->time('time');
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
		Schema::drop('ratings');
	}

}
