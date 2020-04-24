<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangFieldToStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students_info', function(Blueprint $table)
		{
			$table->enum('lang',Config::get('app.available_language'));
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
			$table->dropColumn('lang');
		});
	}

}
