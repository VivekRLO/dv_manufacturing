<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayWiseRouteSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_wise_route_setups', function (Blueprint $table) {
            $table->increment('id');
            $table->foreign('route_id')->references('id')->on('route_names');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('day');
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
        Schema::dropIfExists('day_wise_route_setups');
    }
}
