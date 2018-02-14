<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugAndAllowRegistrationUntilAndExternalIdSettingsToSemesters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
            $table->dateTime('allow_registration_until')->nullable();
            $table->boolean('has_external_id')->default(false);
            $table->string('external_id_label')->nullable();
            $table->boolean('require_external_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropColumn(['slug',
                'allow_registration_until',
                'has_external_id',
                'external_id_label',
                'require_external_id'
            ]);
        });
    }
}