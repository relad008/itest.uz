<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfirmedAtFieldToStudents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students_info', function(Blueprint $table)
		{
			$table->dateTime('confirmed_at');
			$table->enum('status',['active','deleted'])->default('active');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('students_info', function(Blueprint $table)
		{
			$table->dropColumn('confirmed_at');
			$table->dropColumn('status');
		});
	}

}
