<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThematicCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_categories', function(Blueprint $table)
		{
				$table->increments('id');
				$table->integer('parent_id');
				$table->tinyInteger('depth');
				$table->string('parents');

				$table->string('name');
		});
		Schema::table('test_questions',function ($table)
		{
			$table->integer('t_category_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('t_categories');

		Schema::table('test_questions',function ($table)
		{
			$table->dropColumn('t_category_id');
		});
	}

}
