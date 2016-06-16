<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyBudgetRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_budget_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            // income or expense
            $table->string('type');

            // income, fixed expenses, variable expenses
            $table->string('category');

            $table->string('description');

            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('monthly_budget_records');
    }
}
