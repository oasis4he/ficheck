<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialRatioTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_ratio_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('asset_label');
            $table->text('asset_description');
            $table->string('asset_link')->nullable();
            $table->string('asset_link_text')->nullable();

            $table->string('liability_label');
            $table->text('liability_description');
            $table->string('liability_link')->nullable();
            $table->string('liability_link_text')->nullable();

            $table->string('ratio_label');
            $table->text('ratio_description');

            $table->integer('order')->unsigned();

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
        Schema::drop('financial_ratio_types');
    }
}
