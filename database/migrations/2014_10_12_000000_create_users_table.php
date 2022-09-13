<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('role');
            $table->tinyInteger('type');
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->bigInteger('marketing_director_id')->unsigned()->nullable();
            $table->bigInteger('marketing_manager_id')->unsigned()->nullable();
            $table->bigInteger('sales_supervisor_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->foreign('marketing_director_id')->references('id')->on('users');
            $table->foreign('marketing_manager_id')->references('id')->on('users');
            $table->foreign('sales_supervisor_id')->references('id')->on('users');
            $table->string('api_token', 80)->unique()->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
