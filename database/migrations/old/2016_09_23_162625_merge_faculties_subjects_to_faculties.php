<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergeFacultiesSubjectsToFaculties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {

			$table->integer('subject_1_id')->unsigned();
			$table->integer('subject_2_id')->unsigned();
			$table->integer('subject_3_id')->unsigned();
			$table->integer('native_subject')->unsigned();
			$table->integer('foreign_subject')->unsigned();
        });
        $prefix=Config::get('database.connections.'.Config::get('database.default').'.prefix');
        DB::update("UPDATE  `{$prefix}faculties` f
        	LEFT JOIN {$prefix}directions_faculties df ON f.code=df.direction_dtm_id
        	LEFT JOIN {$prefix}directions d ON df.direction_id=d.id
        	SET f.subject_1_id=d.subject_1_id,
        	 f.subject_2_id=d.subject_2_id,
        	 f.subject_3_id=d.subject_3_id,
        	 f.native_subject=d.native_subject,
        	 f.foreign_subject=d.foreign_subject;"
        	 );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculties', function (Blueprint $table) {

			$table->dropColumn('subject_1_id');
			$table->dropColumn('subject_2_id');
			$table->dropColumn('subject_3_id');
			$table->dropColumn('native_subject');
			$table->dropColumn('foreign_subject');
        });
    }
}
