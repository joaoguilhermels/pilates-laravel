<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientPlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_plan_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('client_plan_id')->unsigned()->index();
            $table->foreign('client_plan_id')->references('id')->on('client_plans');

            $table->integer('day_of_week');
            $table->time('hour');

            $table->integer('professional_id')->unsigned()->index();
            $table->foreign('professional_id')->references('id')->on('professionals');

            $table->integer('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('rooms');

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
        Schema::drop('client_plan_details');
    }
}
