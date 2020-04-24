<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('meta_description_ru')->nullable()->change();
            $table->string('meta_description_uz')->nullable()->change();
            $table->string('meta_keywords_ru')->nullable()->change();
            $table->string('meta_keywords_uz')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('meta_description_ru')->change();
            $table->string('meta_description_uz')->change();
            $table->string('meta_keywords_ru')->change();
            $table->string('meta_keywords_uz')->change();
        });
    }
}
