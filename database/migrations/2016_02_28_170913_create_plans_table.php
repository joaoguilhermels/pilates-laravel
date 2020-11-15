<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('class_type_id')->unsigned()->index();
            $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('cascade');

            $table->integer('times');
            $table->enum('times_type', ['week', 'month', 'class'])->default('week'); // class = package
            $table->float('price');
            $table->enum('price_type', ['class', 'month', 'package'])->default('month'); // package is only used with class times_type
            $table->integer('duration');
            $table->enum('duration_type', ['week', 'month', 'do-not-repeat'])->default('month'); // do-not-repeat waiting for a better name
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
        Schema::drop('plans');
    }
}
