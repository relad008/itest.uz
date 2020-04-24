<?php
namespace App\Library\Payments\Paynet;

use Illuminate\Database\Schema\Blueprint,
	Illuminate\Database\Migrations\Migration,
	Config,
	Schema;

class AppendMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table(Config::get('payments.table_prefix').'payments', function (Blueprint $table)
		{
	    	$table->integer('paynet_service_id')->unsigned(); // Идентификатор сервиса
			$table->string('paynet_transaction_time', 30)->default(''); // Дата и время транзакции в paynet
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table(Config::get('payments.table_prefix').'payments',function ($table)
		{
			$table->dropColumn('paynet_service_id');
			$table->dropColumn('paynet_transaction_time');
		});
    }
}
