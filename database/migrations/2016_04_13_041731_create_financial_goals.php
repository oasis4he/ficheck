<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialGoals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('financial_goal_type_id')->unsigned();

            $table->text('description');
            $table->text('plan');

            $table->decimal('cost', 19, 2);
            $table->date('date');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('financial_goal_type_id')->references('id')->on('financial_goal_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('financial_goals');
    }
}
