<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserIdToMonthIdOnMonthlyTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_tracking_records', function (Blueprint $table) {
            $table->dropForeign('monthly_tracking_records_user_id_foreign');
            $table->dropColumn('user_id');

            $table->integer('month_id')->unsigned()->after('id');
            $table->foreign('month_id')->references('id')->on('tracked_months');
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
          $table->dropForeign('monthly_tracking_records_month_id_foreign');
          $table->dropColumn('month_id');

          $table->integer('user_id')->unsigned()->after('id');
          $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
