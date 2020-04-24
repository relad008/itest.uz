<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectsToStudentsInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students_info', function(Blueprint $table)
		{
			$table->integer('subject_1_id');
			$table->integer('subject_2_id');
			$table->integer('subject_3_id');
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
			$table->dropColumn('subject_1_id');
			$table->dropColumn('subject_2_id');
			$table->dropColumn('subject_3_id');
		});
	}

}
