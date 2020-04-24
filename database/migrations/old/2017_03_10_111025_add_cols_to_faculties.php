<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToFaculties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->decimal('avg_contract_ball',6,3)->after('contract_ball');
            $table->decimal('avg_grant_ball',6,3)->after('contract_ball');
        });

        // Add new universities
        DB::unprepared("
            UPDATE test_universities SET dtm_id = id;
            INSERT INTO test_universities(name_ru,name_uz,dtm_id) VALUES('Ташкентский государственный  стоматологический институт', 'Toshkent davlat stomatologiya instituti', 143);
            INSERT INTO test_universities(name_ru,name_uz,dtm_id) VALUES('Нукусский филиал Ташкентского государственного  стоматологического института', 'Toshkent davlat stomatologiya instituti Nukus filiali', 145);
            INSERT INTO test_universities(name_ru,name_uz,dtm_id) VALUES('Андижанский филиал Ташкентского государственного  стоматологического института', 'Toshkent davlat stomatologiya instituti Andijon filiali', 147);
            INSERT INTO test_universities(name_ru,name_uz,dtm_id) VALUES('Бухарский филиал Ташкентского государственного  стоматологического института', 'Toshkent davlat stomatologiya instituti Buxoro filiali', 149);
            INSERT INTO test_universities(name_ru,name_uz,dtm_id) VALUES('Самаркандский филиал Ташкентского государственного  стоматологического института', 'Toshkent davlat stomatologiya instituti Samarqand filiali', 151);
            INSERT INTO test_universities(name_ru,name_uz,dtm_id) VALUES('Ташкентский государственный университет узбекского языка и литературы', 'Toshkent davlat o\'zbek tili va adabiyoti universiteti', 155);
        ");

        // Fixed old base
        DB::unprepared("
            UPDATE test_faculties SET lang = 'tj' WHERE lang = ' тад';
            UPDATE test_faculties SET lang = 'qr' WHERE lang = 'tm';
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropColumn(['avg_grant_ball', 'avg_contract_ball']);
        });
    }
}
