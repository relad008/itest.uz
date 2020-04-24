<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypesToAccout extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('accounts', function(Blueprint $table)
		{
			$table->string('old_type');
		});

		DB::table('accounts')->update(['old_type'=>DB::raw('type')]);

		Schema::table('accounts', function(Blueprint $table)
		{
			$table->dropColumn('type');
		});

		Schema::table('accounts', function(Blueprint $table)
		{
			$table->enum('type',['paynet','click','price','admin','bonus','cheater']);
		});

		DB::table('accounts')->update(['type'=>DB::raw('old_type')]);

		Schema::table('accounts', function(Blueprint $table)
		{
			$table->dropColumn('old_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
