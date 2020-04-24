<?php
namespace App\Library\Payments;

use Illuminate\Database\Schema\Blueprint,
	Illuminate\Database\Migrations\Migration,
	Config,
	Schema;

class BaseDBMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create(Config::get('payments.table_prefix').'payments', function (Blueprint $table)
		{
	    	$table->increments('id');
			$table->string('account_id',15);
			$table->integer('amount')->unsigned();
			$table->integer('amount_tiin')->unsigned();
			$table->string('system_transaction_id', 30);
			$table->enum('system',array_keys(Config::get('payments.systems',[])));
			$table->enum('state', ['pending','commited','canceled','canceled_after_commit'])->default('pending');
			$table->text('parameters');
			$table->timestamps();
			$table->index('account_id');
			$table->index(['system','system_transaction_id']);
		});


		Schema::create(Config::get('payments.table_prefix').'paymetnts_log', function ( $table)
		{
			$table->increments('id');
			$table->enum('system',array_keys(Config::get('payments.systems',[])));
			$table->text('request');
			$table->text('response');
			$table->timestamp('created_at');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::drop(Config::get('payments.table_prefix').'payments');
    	Schema::drop(Config::get('payments.table_prefix').'paymetnts_log');
    }
}
