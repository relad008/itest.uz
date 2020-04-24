<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangToCategory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->string('name_uz')->after('name');
			$table->string('name_ru')->after('name');
		});
		DB::table('test_categories')->update(['name_uz'=>DB::raw('`name`'),'name_ru'=>DB::raw('`name`'),]);

		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->dropColumn('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->string('name');
		});
		DB::table('test_categories')->update(['name'=>DB::raw('`name_ru`'),]);
		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->dropColumn('name_uz');
			$table->dropColumn('name_ru');
		});
	}

}
