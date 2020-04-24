<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStudentInfoSctuct extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('students_info');
		Schema::create('students_info', function(Blueprint $table)
		{
				$table->integer('user_id')->unique();
				$table->integer('city_id');
				$table->integer('district_id');
				$table->string('phone');
				$table->string('phone_conformation');
				$table->enum('confirmed',[0,1]);
				$table->integer('university_id');
				$table->integer('faculty_id');
				$table->date('b_day');
				$table->string('address');
				$table->enum('lang',Config::get('app.available_language'));
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

	}

}
