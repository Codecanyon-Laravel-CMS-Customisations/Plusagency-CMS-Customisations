<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('alpha_2_code', 7)->nullable()->unique()->comment('eg IN');
            $table->string('alpha_3_code', 7)->nullable()->unique()->comment('eg IND');
            $table->string('calling_codes', 77)->nullable()->comment('csv entries');
            $table->string('alt_spellings')->nullable()->comment('csv entries');
            $table->string('region')->nullable();
            $table->string('sub_region')->nullable();
            $table->string('demonym')->nullable();
            $table->string('timezones')->nullable()->comment('csv entries');
            $table->string('native_name')->nullable();
            $table->boolean('status')->nullable()->default(false)->comment('only active countries will be visible to clients');
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
        Schema::dropIfExists('countries');
    }
}
