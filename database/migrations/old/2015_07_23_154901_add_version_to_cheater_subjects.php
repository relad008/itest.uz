<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVersionToCheaterSubjects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cheater_subjects', function(Blueprint $table)
		{
			$table->integer('version')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cheater_subjects', function(Blueprint $table)
		{
			$table->dropColumn('version');
		});
	}

}
