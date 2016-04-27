<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialRatioRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_ratio_records', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->integer('financial_ratio_type_id')->unsigned();

            $table->decimal('asset', 19, 2);
            $table->decimal('liability', 19, 2);
            $table->decimal('ratio', 19, 2);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('financial_ratio_type_id')->references('id')->on('financial_ratio_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('financial_ratio_records');
    }
}
