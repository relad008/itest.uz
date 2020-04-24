<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ForumTopic;
class AddFieldsToForum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_topics', function (Blueprint $table)
        {
            $table->enum('lang',Config::get('app.available_language'))->after('id');
            $table->integer('watches')->unsigned();
            $table->integer('theme_id')->unsigned()->after('title');
            $table->integer('comments_count')->unsigned()->after('title');
        });
        $prefix=Config::get('database.connections.'.Config::get('database.default').'.prefix');

        DB::update("UPDATE `{$prefix}forum_topics` t set comments_count=(select count(id) FROM `{$prefix}forum_comments` c where c.topic_id=t.id)");


        Schema::table('forum_comments', function (Blueprint $table)
        {

            $table->integer('parent_id')->unsigned()->default(0)->after('topic_id');
            $table->integer('order')->unsigned()->default(0);
        });
        DB::table('forum_comments')->where('parent_id',0)->update(['order'=>DB::raw('parent_id')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_topics', function (Blueprint $table)
        {
            $table->dropColumn('theme_id');
            $table->dropColumn('lang');
            $table->dropColumn('watches');
            $table->dropColumn('comments_count');
        });

        Schema::table('forum_comments', function (Blueprint $table)
        {
            $table->dropColumn('parent_id');
            $table->dropColumn('order');
        });
    }
}
