<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCalculatorToMonthlyBudgetRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_budget_records', function (Blueprint $table) {
            $table->string('calculator')->default('monthly-budget');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_budget_records', function (Blueprint $table) {
            $table->dropColumn('calculator');
        });
    }
}
