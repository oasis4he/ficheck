<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGradedAtToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('graded_at')->nullable();
            $table->integer('graded_by')->unsigned()->nullable();

            $table->foreign('graded_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_graded_by_foreign');

            $table->dropColumn('graded_at');
            $table->dropColumn('graded_by');
        });
    }
}
