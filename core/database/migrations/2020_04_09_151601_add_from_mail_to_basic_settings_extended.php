<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFromMailToBasicSettingsExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->string('from_mail', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->dropColumn('from_mail');
        });
    }
}
