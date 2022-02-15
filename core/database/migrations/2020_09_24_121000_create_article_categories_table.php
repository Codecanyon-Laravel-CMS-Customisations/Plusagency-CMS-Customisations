<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('article_categories', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->integer('language_id');
      $table->string('name');
      $table->tinyInteger('status')->default(1);
      $table->integer('serial_number');
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
    Schema::dropIfExists('article_categories');
  }
}
