<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetirementNeedsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retirement_needs_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            $table->decimal('annual_income', 19, 2);
            $table->decimal('annual_ss_benefit', 19, 2);
            $table->decimal('annual_employer_benefit', 19, 2);
            $table->decimal('additional_annual_income_required', 19, 2);
            $table->integer('desired_retirement_age');
            $table->decimal('retirment_age_factor', 3, 2);
            $table->decimal('retirment_goal', 19, 2);

            $table->decimal('employee_retirment_savings', 19, 2);
            $table->decimal('personal_retirment_savings', 19, 2);
            $table->decimal('investements_value', 19, 2);
            $table->decimal('retirement_savings_and_investments', 19, 2);

            $table->integer('desired_years_until_retirement');
            $table->decimal('retirment_years_factor', 3, 2);
            $table->decimal('future_value_of_savings_and_investments', 19, 2);

            $table->decimal('entered_retirment_goal', 19, 2);
            $table->decimal('entered_future_value_of_savings_and_investments', 19, 2);
            $table->decimal('additional_savings_needed_for_retirement', 19, 2);
            $table->integer('entered_desired_retirement_age');
            $table->decimal('entered_retirment_age_factor', 3, 2);
            $table->decimal('addition_annual_savings_required', 19, 2);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('retirement_needs_records');
    }
}
