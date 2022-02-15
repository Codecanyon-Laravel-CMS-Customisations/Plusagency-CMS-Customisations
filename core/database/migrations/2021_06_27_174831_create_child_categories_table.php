<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_categories', function (Blueprint $table) {
            try
            {
                $table->bigIncrements('id');
                $table->string('name')->nullabe();
                $table->string('slug')->nullabe();
                $table->bigInteger('language_id')->unsigned()->default(0)->index();
                $table->integer('status')->default(1);
                $table->integer('is_feature')->default(0);
                $table->timestamps();

                $table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');
            }
            catch (\Exception $exception)
            {
                //throw $exception;
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_categories');
    }
}
