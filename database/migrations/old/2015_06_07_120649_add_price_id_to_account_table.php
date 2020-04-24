<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceIdToAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('accounts', function(Blueprint $table)
		{
			$table->dropColumn('type');
		});

		Schema::table('accounts', function(Blueprint $table)
		{
			$table->integer('price_id');
			$table->enum('type',['paynet','click','price']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('accounts', function(Blueprint $table)
		{
			$table->dropColumn('price_id');

		});
	}

}
