<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Faculties extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faculties',function ($table)
		{
			$table->increments('id');
			$table->string('name_ru');
			$table->string('name_uz');
			$table->string('code',10);
			$table->string('lang',10);
			$table->integer('university_id');
			$table->integer('total_students');
			$table->integer('grant_count');
			$table->integer('contract_count');
			$table->decimal('grant_ball',6,3);
			$table->decimal('contract_ball',6,3);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('faculties');
	}

}
