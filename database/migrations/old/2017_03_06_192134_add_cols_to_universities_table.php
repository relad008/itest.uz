<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsToUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->string('subtitle_ru');
            $table->string('subtitle_uz');
            $table->date('founded_at');
            $table->string('address_ru');
            $table->string('address_uz');
            $table->string('phone');
            $table->integer('contract_min')->unsigned()->default(0);
            $table->integer('contract_max')->unsigned()->default(0);
            $table->integer('city_id')->unsigned()->default(0);
            $table->text('about_uz');
            $table->text('about_ru');
            $table->boolean('hostel')->default(0);
            $table->boolean('foreign')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn([
                'subtitle_ru',
                'subtitle_uz',
                'founded_at',
                'address_ru',
                'address_uz',
                'phone',
                'contract_min',
                'contract_max',
                'city_id',
                'about_uz',
                'about_ru',
                'hostel',
                'foreign',
            ]);
        });
    }
}
