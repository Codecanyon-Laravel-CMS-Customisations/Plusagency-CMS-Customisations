<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_conversions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('base_currency_id')->unsigned()->nullable()->index()->comment('the base currency id');
            $table->bigInteger('converted_currency_id')->unsigned()->nullable()->index()->comment('the currency being converted to id');
            $table->float('rate', 7)->nullable()->default(1.00);
            $table->boolean('status')->nullable()->default(false)->comment('only active conversions will be visible to clients');
            $table->timestamps();

            $table->foreign('base_currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('converted_currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_conversions');
    }
}
