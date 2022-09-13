<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('distributor_id')->unsigned();
            $table->integer('batch_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('price');
            $table->integer('total_stock_remaining_in_distributor');
            $table->integer('stock_in')->comment("issued by admin")->nullable();
            $table->integer('stock_out')->comment("stock out from distributor after verify by sale officer")->nullable();
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
        Schema::drop('stock_histories');
    }
}
