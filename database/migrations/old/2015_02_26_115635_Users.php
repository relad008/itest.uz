<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->down();
		Schema::create('users',function($table){
			$table->increments('id');
			$table->string('email',100);
			$table->string('pass',32);
			$table->string('name',100);
			$table->enum('photo',[0,1]);
			$table->enum('role',Auth::$roles);
			$table->timestamps();

			// $table->primary('id');
			$table->unique('email');

		});

		Schema::create('teacher_categories',function($table){
			$table->integer('teacher_id');
			$table->integer('category_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
		Schema::dropIfExists('teacher_categories');
	}

}
