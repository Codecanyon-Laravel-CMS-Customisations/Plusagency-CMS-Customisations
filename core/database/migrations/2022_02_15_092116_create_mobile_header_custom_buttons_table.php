<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileHeaderCustomButtonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_header_custom_buttons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('language_id')->unsigned()->nullable()->index();
            $table->text('link_text')->nullable()->comment('can support html content');
            $table->text('link_url')->nullable()->comment('where the hyperlink redirects to');
            $table->text('link_target')->nullable()->comment('if = \'_blank\' open in new window');
            $table->text('description')->nullable()->comment('more info to where the link leads to');
            $table->integer('link_rank')->nullable()->comment('help in ordering links on the web page');
            $table->boolean('status')->nullable()->default(true)->comment('only show active links');
            $table->timestamps();

            // $table->foreign('language_id')->references('id')->on('languages')
            // ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_header_custom_buttons');
    }
}
