<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeedBack extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback',function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('subject');
			$table->text('description');
			$table->integer('user_id');
			$table->enum('status',['new','fixed']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('feedback');
	}

}
