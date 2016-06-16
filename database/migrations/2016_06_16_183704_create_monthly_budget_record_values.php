<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyBudgetRecordValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_budget_record_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id')->unsigned();

            // planned, actual, difference
            $table->string('type');

            $table->decimal('value', 19, 2);

            $table->foreign('record_id')->references('id')->on('monthly_budget_records');

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
        Schema::drop('monthly_budget_record_values');
    }
}
