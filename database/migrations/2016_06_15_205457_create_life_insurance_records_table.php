<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLifeInsuranceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('life_insurance_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            $table->decimal('annual_income', 19, 2)->nullable();
            $table->decimal('insurance_needs', 19, 2)->nullable();
            $table->integer('years_income_replacement_needed')->nullable();
            $table->decimal('income_replacement_factor', 19, 2)->nullable();
            $table->decimal('total_income_replacement', 19, 2)->nullable();

            $table->decimal('funeral_expenses', 19, 2)->nullable();
            $table->decimal('debt', 19, 2)->nullable();
            $table->decimal('other_expenses', 19, 2)->nullable();
            $table->decimal('entered_total_income_replacement', 19, 2)->nullable();
            $table->decimal('total_expenses', 19, 2)->nullable();

            $table->integer('gevernment_benefits')->nullable();
            $table->decimal('other_funds', 19, 2)->nullable();
            $table->decimal('total_funds_from_other_sources', 19, 2)->nullable();

            $table->decimal('entered_total_expenses', 19, 2)->nullable();
            $table->decimal('entered_total_funds_from_other_sources', 19, 2)->nullable();
            $table->decimal('insurance_needed', 19, 2)->nullable();

            $table->timestamps();

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
        Schema::drop('life_insurance_records');
    }
}
