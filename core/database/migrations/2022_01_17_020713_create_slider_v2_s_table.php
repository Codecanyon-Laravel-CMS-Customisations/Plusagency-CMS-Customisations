<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderV2STable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_v2_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('language_id')->default(0);
            $table->string('title', 255)->nullable();
            $table->string('text', 255)->nullable();
            $table->string('slider_category', 77)->nullable()->comment('eg main, side1, side2');
            $table->string('button_text', 255)->nullable();
            $table->string('button_url', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('serial_number')->default(0);
            $table->string('title_font_size', 77)->nullable();
            $table->text('bold_text')->nullable();
            $table->string('bold_text_color', 77)->nullable();
            $table->string('bold_text_font_size', 77)->nullable();
            $table->string('text_font_size', 77)->nullable();
            $table->string('button_text_font_size', 77)->nullable();
            $table->string('side_image')->nullable();
            $table->string('another_button_text')->nullable();
            $table->string('another_button_text_font_size', 77)->nullable();
            $table->text('another_button_url')->nullable();
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
        Schema::dropIfExists('slider_v2_s');
    }
}
