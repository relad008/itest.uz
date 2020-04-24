<?php
namespace App\Library\Payments\Paycom;

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
	    	// Время создания в системе Paycom
			$table->string('paycom_system_time_created', 14)->default(0);
			// Время создания в нашей системе
			$table->string('paycom_time_created', 14)->default(0);
			// Время подтверждения в нашей системе
			$table->string('paycom_time_preform', 14)->default(0);
			// Время отмены в нашей системе
			$table->string('paycom_time_canceled', 14)->default(0);
			// Причина отмены
			$table->enum('paycom_cancel_reason', array_keys(Controller::$cancel_trunsaction_resons))->default('-');
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
			$table->dropColumn('paycom_system_time_created');
			$table->dropColumn('paycom_time_created');
			$table->dropColumn('paycom_time_preform');
			$table->dropColumn('paycom_time_canceled');
			$table->dropColumn('paycom_cancel_reason');
		});
    }
}
