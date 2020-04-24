<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectTypeToCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->enum('subject_type',['-','foreign','native'])->default('-');
			$table->string('subject_lang');
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
			$table->dropColumn('subject_type');
			$table->dropColumn('subject_lang');
		});
	}

}
