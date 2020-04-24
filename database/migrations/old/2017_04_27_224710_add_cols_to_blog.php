<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\BlogCategory;

class AddColsToBlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('view_count')->unsigned()->after('lang');
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('meta_keywords_ru')->after('name_ru');
            $table->string('meta_description_ru')->after('name_ru');
            $table->string('alias')->after('name_uz');
            $table->string('meta_keywords_uz')->after('name_uz');
            $table->string('meta_description_uz')->after('name_uz');
        });

        $categories = BlogCategory::all();

        foreach($categories as $category) {
            $category->alias = $this->aliasCreate($category->name_ru);
            $category->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('view_count');
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn('alias');
        });
    }

    private function aliasCreate($value)
    {
        $slug = str_slug($value);
        $model = new BlogCategory;
        $slugCount = count($model->whereRaw("alias REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}
