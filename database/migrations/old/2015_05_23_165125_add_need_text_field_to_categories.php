<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNeedTextFieldToCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->enum('need_text',[0,1])->default(0);
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
			$table->dropColumn('need_text');
		});
	}

}
