<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('price',10,2);
			$table->enum('thematic_available',[0,1]);
			$table->enum('direction_available',[0,1]);
			$table->string('name_ru');
			$table->string('name_uz');
			$table->enum('disabled',[0,1]);
			$table->integer('days_to_expired');
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
		Schema::drop('prices');
	}

}
