<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('distributor_id')->unsigned();
            $table->integer('batch_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->bigInteger('quantity');
            $table->dateTime('returndate');
            $table->text('remarks');
            $table->timestamps();
            $table->foreign('distributor_id')->references('id')->on('distributors');
            $table->foreign('batch_id')->references('id')->on('batches');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sale_returns');
    }
}
