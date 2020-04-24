<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tests extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->down();

		Schema::create('test_categories',function($table){
			$table->increments('id');

			$table->integer('parent_id');
			$table->tinyInteger('depth');
			$table->string('parents');

			$table->tinyInteger('from');
			$table->tinyInteger('to');

			$table->enum('hide_subcategory',[0,1]);

			$table->string('name');
		});


		Schema::create('test_questions',function($table){
			$table->increments('id');

			$table->integer('creator_id');
			// from Categories
			$table->integer('category_id');


			$table->text('description');

			$table->string('A',1000);
			$table->string('B',1000);
			$table->string('C',1000);
			$table->string('D',1000);

			$table->enum('correct_answer',['-','A','B','C','D']);


		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('test_questions');
		Schema::dropIfExists('test_categories');
	}

}
