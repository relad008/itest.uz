<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangToQuestions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_questions', function(Blueprint $table)
		{
			$table->enum('lang',Config::get('app.available_language'))->default('uz');
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
			$table->dropColumn('lang');
		});
	}

}
