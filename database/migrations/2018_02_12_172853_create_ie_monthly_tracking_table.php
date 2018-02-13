<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIeMonthlyTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ie_monthly_tracking_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('month_id')->unsigned();

            $table->decimal('value', 19, 2)->nullable();
            $table->date('occurred_at');
            $table->string('category')->index();

            $table->timestamps();

            $table->foreign('month_id')->references('id')->on('ie_tracked_months');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ie_monthly_tracking_records');
    }
}
