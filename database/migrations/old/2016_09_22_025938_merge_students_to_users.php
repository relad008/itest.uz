<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\OldModels\Student;
class MergeStudentsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

			$table->integer('city_id');
			$table->integer('district_id');
			$table->string('phone');
			$table->string('phone_conformation');
			$table->integer('university_id');
			$table->integer('faculty_id');
			$table->date('b_day');
			$table->string('address');
			$table->enum('lang',Config::get('app.available_language'));
			$table->dateTime('confirmed_at');
			$table->enum('status',['active','deleted'])->default('active');
			$table->integer('subject_1_id');
			$table->integer('subject_2_id');
			$table->integer('subject_3_id');
			$table->enum('year_subscribe',[0,1]);
        });
       $prefix=Config::get('database.connections.'.Config::get('database.default').'.prefix');
		$affected = DB::update(
			"UPDATE {$prefix}users u LEFT JOIN {$prefix}students_info s
				on s.user_id=u.id
				SET
				u.city_id=s.city_id ,
				u.district_id=s.district_id ,
				u.phone=s.phone ,
				u.phone_conformation=s.phone_conformation ,
				u.confirmed=s.confirmed ,
				u.university_id=s.university_id ,
				u.faculty_id=s.faculty_id ,
				u.b_day=s.b_day ,
				u.address=s.address ,
				u.lang=s.lang ,
				u.confirmed_at=s.confirmed_at ,
				u.`status`=s.`status` ,
				u.subject_1_id=s.subject_1_id ,
				u.subject_2_id=s.subject_2_id ,
				u.subject_3_id=s.subject_3_id ,
				u.year_subscribe=s.year_subscribe
				;"
			);
		echo $affected;


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('city_id');
			$table->dropColumn('district_id');
			$table->dropColumn('phone');
			$table->dropColumn('phone_conformation');
			$table->dropColumn('confirmed');
			$table->dropColumn('university_id');
			$table->dropColumn('faculty_id');
			$table->dropColumn('b_day');
			$table->dropColumn('address');
			$table->dropColumn('lang');
			$table->dropColumn('confirmed_at');
			$table->dropColumn('status');
			$table->dropColumn('subject_1_id');
			$table->dropColumn('subject_2_id');
			$table->dropColumn('subject_3_id');
			$table->dropColumn('year_subscribe');
        });
    }
}
