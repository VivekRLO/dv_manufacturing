<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sales_officer_id')->unsigned();
            $table->integer('distributor_id')->unsigned();
            $table->integer('batch_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');
            $table->string('sold_at');
            $table->string('discount')->nullable();
            $table->bigInteger('outlet_id')->unsigned();
            $table->foreign('sales_officer_id')->references('id')->on('users');
            $table->foreign('distributor_id')->references('id')->on('distributors');
            $table->foreign('batch_id')->references('id')->on('batches');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('outlet_id')->references('id')->on('outlets');

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
        Schema::drop('sales');
    }
}
