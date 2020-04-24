<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Directions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('directions',function ($table)
		{
			$table->increments('id');
			$table->string('dtm_id');
			$table->string('free_subjects');
			$table->integer('subject_1_id');
			$table->integer('subject_2_id');
			$table->integer('subject_3_id');
			$table->float('ball_1');
			$table->float('ball_2');
			$table->float('ball_3');
			$table->integer('foreign_subject');

		});
		Schema::create('directions_faculties',function ($table)
		{
			$table->integer('direction_id');
			$table->integer('direction_dtm_id');
			$table->integer('faculty_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('directions');
		Schema::drop('directions_faculties');
	}

}
