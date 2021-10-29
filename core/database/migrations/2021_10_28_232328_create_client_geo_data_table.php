<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientGeoDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_geo_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('country_id')->unsigned()->nullable()->index();
            $table->bigInteger('currency_id')->unsigned()->nullable()->index();
            $table->string('ip',77)->unique()->comment('ipv4 entry');
            $table->string('ipv6',77)->nullable()->comment('ipv6 entry');
            $table->string('country_code',7)->nullable()->comment('alphaCode2 e.g IN');
            $table->string('country_name')->nullable()->comment('e.g INDIA');
            $table->string('region_code', 77)->nullable()->comment('eg 30');
            $table->string('region_name')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code', 77)->nullable();
            $table->string('time_zone', 77)->nullable();
            $table->string('latitude', 77)->nullable();
            $table->string('longitude', 77)->nullable();
            $table->string('metro_code', 77)->nullable();
            $table->string('unix_expiry_time', 25)->nullable()->comment('time in unix when record will expire');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_geo_data');
    }
}
