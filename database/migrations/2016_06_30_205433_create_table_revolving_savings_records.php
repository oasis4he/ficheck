<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRevolvingSavingsRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revolving_savings_records', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();

          $table->string('description');
          $table->string('value');
          $table->integer('month');

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
        Schema::drop('revolving_savings_records');
    }
}
