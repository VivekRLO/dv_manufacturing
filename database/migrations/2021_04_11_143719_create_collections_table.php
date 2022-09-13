<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('distributor_id')->unsigned();
            $table->string('mode');
            $table->string('bank_name')->nullable();
            $table->string('cheque_no')->nullable();
            $table->text('cheque_photo')->nullable();
            $table->float('amount');
            $table->bigInteger('sales_officer_id')->unsigned();
            $table->string('account_of');
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->string('device_time');
            $table->foreign('distributor_id')->references('id')->on('distributors');
            $table->foreign('sales_officer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('collections');
    }
}
