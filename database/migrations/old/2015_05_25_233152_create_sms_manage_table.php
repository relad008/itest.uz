<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsManageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('str_id');
			$table->string('to');
			$table->string('balance');
			$table->string('price');
			$table->enum('status',SMS::$db_status_list);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sms_messages');
	}

}
