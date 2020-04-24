<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()
              ->getDoctrineSchemaManager()
              ->getDatabasePlatform()
              ->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable()->change();
            $table->string('meta_description')->nullable()->change();
            $table->integer('view_count')->unsigned()->default(0)->change();
            $table->integer('user_id')->unsigned()->after('view_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::getConnection()
              ->getDoctrineSchemaManager()
              ->getDatabasePlatform()
              ->registerDoctrineTypeMapping('enum', 'string');
              
              
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('meta_keywords')->change();
            $table->string('meta_description')->change();
            $table->integer('view_count')->unsigned()->change();
            $table->dropColumn('user_id');
        });
    }
}
