<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCountsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('stock');
            $table->string('type');
            $table->string('date');
            $table->bigInteger('sale_officer_id')->unsigned();
            $table->integer('distributor_id')->unsigned();
            $table->timestamps();
            $table->foreign('sale_officer_id')->references('id')->on('users');
            $table->foreign('distributor_id')->references('id')->on('distributors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stock_counts');
    }
}
