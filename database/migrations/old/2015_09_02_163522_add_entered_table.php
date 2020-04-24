<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnteredTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entered', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name');
			$table->string('ball');
			$table->string('university');
			$table->text('comment');
			$table->string('region');
			$table->string('area_name');
			$table->string('phone');
			$table->string('m_phone');
			$table->string('f_phone');
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
		Schema::drop('entered');
	}

}
