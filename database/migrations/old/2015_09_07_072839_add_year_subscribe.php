<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearSubscribe extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students_info', function(Blueprint $table)
		{
			$table->enum('year_subscribe',[0,1]);

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
			$table->dropColumn('year_subscribe');
		});
	}

}
