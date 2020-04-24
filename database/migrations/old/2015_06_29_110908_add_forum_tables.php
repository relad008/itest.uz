<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForumTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forum_topics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('message');
			$table->integer('user_id');
			$table->integer('category_id');
			$table->dateTime('moderated_at');
			$table->enum('status',['new','moderated','deleted','closed']);
			$table->timestamps();
		});
		Schema::create('forum_comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('topic_id');
			$table->integer('user_id');
			$table->dateTime('moderated_at');
			$table->enum('status',['new','moderated','deleted']);
			$table->text('message');

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
		Schema::drop('forum_topics');
		Schema::drop('forum_comments');
	}

}
