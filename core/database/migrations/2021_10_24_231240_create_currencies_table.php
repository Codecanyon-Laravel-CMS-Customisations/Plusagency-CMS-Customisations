<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->comment('eg Indian Rupee');
            $table->string('acronym', 7)->nullable()->comment('eg IN');
            $table->string('symbol', 7)->nullable()->comment('eg ₹');
            $table->string('symbol_position', 7)->nullable()->comment('eg L for left, R for right');
            $table->string('text_position', 7)->nullable()->comment('eg L for left, R for right');
            $table->boolean('status')->nullable()->default(false)->comment('only active currencies will be visible to clients');
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
        Schema::dropIfExists('currencies');
    }
}
