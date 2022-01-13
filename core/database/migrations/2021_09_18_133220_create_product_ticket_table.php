<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ticket', function (Blueprint $table) {
            try
            {
                $table->bigIncrements('id');
                $table->bigInteger('product_id')->unsigned()->nullable()->index();
                $table->bigInteger('ticket_id')->unsigned()->nullable()->index();
                $table->bigInteger('user_id')->unsigned()->nullable()->index();
                $table->string('preferred_communication', 77)->nullable();
                $table->string('whatsapp_number', 77)->nullable();
                $table->string('email', 77)->nullable();
                $table->timestamps();

                $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('set null');
                $table->foreign('ticket_id')->references('id')->on('tickets')->onUpdate('cascade')->onDelete('set null');
                $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('product_ticket');
    }
}
