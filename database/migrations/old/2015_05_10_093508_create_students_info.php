<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students_info', function(Blueprint $table)
		{
			$table->integer('user_id');
			$table->integer('city');
			$table->integer('district');
			$table->integer('phone');
			$table->string('university');
			$table->string('faculty');
			$table->date('b_day');
			$table->string('address');
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
		Schema::drop('students_info');
	}

}
