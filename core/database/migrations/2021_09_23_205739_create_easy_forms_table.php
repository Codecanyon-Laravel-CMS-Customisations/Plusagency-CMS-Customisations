<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEasyFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easy_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('easy_form_server_url')->nullable();
            $table->text('easy_form_digital')->nullable();
            $table->text('easy_form_restricted')->nullable();
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
        Schema::dropIfExists('easy_forms');
    }
}
