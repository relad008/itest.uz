<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNativeLangToDirection extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('directions', function(Blueprint $table)
		{
			$table->integer('native_subject');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('directions', function(Blueprint $table)
		{
			$table->dropColumn('native_subject');
		});
	}

}
