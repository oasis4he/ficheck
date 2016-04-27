<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_tracking_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            $table->decimal('value', 19, 2)->nullable();
            $table->date('occurred_at');
            $table->string('category')->index();

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
        Schema::drop('monthly_tracking_records');
    }
}
