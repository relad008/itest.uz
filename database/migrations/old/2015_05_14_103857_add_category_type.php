<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Добавляю поле тип и временный индекс старых ID
		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->enum('type',['category','theme','main'])->default('category');
			$table->integer('old_id');
		});
		// Обновляю устанавливаю тип текущим категориям
			DB::table('test_categories')->where('type','!=','category')->update(['type'=>'category']);
			DB::table('test_categories')->where('depth',0)->update(['type'=>'main']);

		$main_categs=[
			1=>8,
			2=>599,
			3=>87,
			4=>86,
			5=>7,
			6=>9,
			7=>10,
			8=>53,
			9=>416,
			10=>1,
		];
		//Составляю индекс для совмещения категорий
		$old_ids='#('.implode('|', array_keys($main_categs)).')#';
		// Выбираю только вложенные темы
		$rows=DB::table('t_categories')->select('id as old_id','name','parents','depth','parent_id')->where('depth','>',0)->get();
		foreach($rows as $ind=>$row)
		{
			$row->type='theme';
			if(isset($main_categs[$row->parent_id]))
				$row->parent_id=$main_categs[$row->parent_id];

			if(preg_match($old_ids, $row->parents,$res))
			{
				$row->parents=str_replace('#'.$res[1].'#','#'.$main_categs[$res[1]].'#', $row->parents);

			}
			DB::table('test_categories')->insert((array)$row);
		}
		$rows=DB::table('test_categories')->where('type','theme')->select('id','old_id')->get();
		foreach($rows as $ind=>$row)
		{
			DB::table('test_categories')->where('type','theme')->where('parents','rlike','#'.$row->old_id.'#')->update(['parents'=>DB::raw('replace(parents,"#'.$row->old_id.'#","#'.$row->id.'#")')]);

			DB::table('test_categories')->where('type','theme')->where('parents',$row->old_id)->update(['parents'=>$row->id]);
		}

		Schema::table('test_categories', function(Blueprint $table)
		{
			$table->dropColumn('old_id');
		});
		Schema::drop('t_categories');
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
			$table->dropColumn('type');
		});
	}

}
