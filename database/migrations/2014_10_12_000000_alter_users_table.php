<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = DB::getTablePrefix().'users';
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';");

        DB::table('users')->whereDate('b_day', '0000-00-00')->update([
            'b_day' => '2022-01-01'
        ]);

        DB::statement('ALTER TABLE '.$this->table."
            CHANGE COLUMN pass password VARCHAR(255),
            CHANGE COLUMN b_day birthdate date DEFAULT NULL,
            MODIFY email varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            MODIFY photo tinyint(1) unsigned NOT NULL DEFAULT '0',
            MODIFY city_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY category_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY conformation varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
            MODIFY confirmed tinyint(1) COLLATE utf8_unicode_ci DEFAULT '0',
            MODIFY chat_token varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
            MODIFY token varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
            MODIFY district_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY phone varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            MODIFY phone_conformation varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',    
            MODIFY university_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY faculty_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY address varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            MODIFY lang enum('uz','ru') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uz',
            MODIFY confirmed_at datetime DEFAULT NULL,
            MODIFY subject_1_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY subject_2_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY subject_3_id int(10) unsigned NOT NULL DEFAULT '0',
            MODIFY year_subscribe tinyint(1) NOT NULL DEFAULT '0',
            MODIFY created_at timestamp NULL DEFAULT NULL,
            MODIFY updated_at timestamp NULL DEFAULT NULL,
            ADD remember_token varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL;
        ");

        DB::table('users')->whereDate('birthdate', '2022-01-01')->update([
            'birthdate' => null
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';");

        DB::table('users')->whereDate('birthdate', null)->update([
            'birthdate' => '2022-01-01'
        ]);

        DB::statement('ALTER TABLE '.$this->table."
            CHANGE COLUMN password pass VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT NULL,
            CHANGE COLUMN birthdate b_day date NOT NULL DEFAULT '0000-00-00',
            MODIFY email VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL,
            MODIFY photo enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
            MODIFY category_id int(11) NOT NULL,
            MODIFY conformation varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            MODIFY confirmed enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
            MODIFY chat_token varchar(32) COLLATE utf8_unicode_ci NOT NULL,
            MODIFY token varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            MODIFY city_id int(11) NOT NULL,
            MODIFY district_id int(11) NOT NULL,
            MODIFY phone varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            MODIFY phone_conformation varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            MODIFY university_id int(11) NOT NULL,
            MODIFY faculty_id int(11) NOT NULL,
            MODIFY address varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            MODIFY lang enum('uz','ru') COLLATE utf8_unicode_ci NOT NULL,
            MODIFY confirmed_at datetime NOT NULL,
            MODIFY status enum('active','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
            MODIFY subject_1_id int(11) NOT NULL,
            MODIFY subject_2_id int(11) NOT NULL,
            MODIFY subject_3_id int(11) NOT NULL,
            MODIFY created_at timestamp NULL DEFAULT NULL,
            MODIFY updated_at timestamp NULL DEFAULT NULL,
            MODIFY year_subscribe enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
            DROP COLUMN remember_token;
        ");

        DB::table('users')->whereDate('b_day', '2022-01-01')->update([
            'b_day' => '0000-00-00'
        ]);
    }
}
