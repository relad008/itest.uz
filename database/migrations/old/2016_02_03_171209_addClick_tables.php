<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClickTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 	public function up()
    {
        App\Lib\Click::createClickTables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        App\Lib\Click::dropClickTables();
    }
}
