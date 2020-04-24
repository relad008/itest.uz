<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangToEntered extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('entered', function(Blueprint $table)
		{
			$table->enum('lang',Config::get('app.available_language',['uz','ru']));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('entered', function(Blueprint $table)
		{
			$table->dropColumn('lang');
		});
	}

}
