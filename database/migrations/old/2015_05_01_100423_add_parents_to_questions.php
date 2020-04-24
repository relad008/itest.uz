<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentsToQuestions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('test_questions',function ($table)
		{
			$table->string('parents',100);
			$table->index('parents');
		});
		$questions=DB::table('test_questions')
			->join('test_categories','test_questions.category_id','=','test_categories.id')
			->select('test_questions.id','test_questions.category_id','test_categories.parents')->get();
		foreach($questions as $q)
		{
			TestQuestion::where('id',$q->id)->update(['parents'=>$q->parents."#{$q->category_id}#"]);
		}



	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('test_questions',function ($table)
		{
			$table->dropColumn('parents');
		});
	}

}
