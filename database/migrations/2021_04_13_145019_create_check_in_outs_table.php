<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckInOutsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_in_outs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sales_officer_id')->unsigned();
            $table->string('check_type');
            $table->double('latitude');
            $table->double('longitude');
            $table->timestamps();
            $table->string('device_time');
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
        Schema::drop('check_in_outs');
    }
}
