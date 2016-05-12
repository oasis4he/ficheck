<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDateOnMonthlyTrackingRecordsToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_tracking_records', function (Blueprint $table) {
            $table->string('occurred_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_tracking_records', function (Blueprint $table) {
            $table->date('occurred_at')->change();
        });
    }
}
