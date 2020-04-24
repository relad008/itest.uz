<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThematicParentsToQuestion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_questions', function(Blueprint $table)
		{
			$table->dropColumn('t_category_id');
			$table->integer('theme_id');
			$table->string('t_parents');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('test_questions', function(Blueprint $table)
		{
			$table->integer('t_category_id');
			$table->dropColumn('theme_id');
			$table->dropColumn('t_parents');
		});
	}

}
