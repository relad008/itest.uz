<?php
namespace App\Library\Payments\Click;

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
    	Schema::create(Config::get('payments.table_prefix').'payments_click_invoices', function ($table)
		{
			$table->increments('id');
			$table->integer('click_trans_id');// ID транзакции в системе CLICK
			$table->integer('account_id')->default(0);// ID платежа\пользователя\товара в нашей системе
			$table->enum('status', ['pending', 'commited', 'canceled'])->default('pending');
			$table->decimal('amount', 13, 2);
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
		Schema::drop(Config::get('payments.table_prefix').'payments_click_invoices');
    }
}
