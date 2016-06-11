<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('free_trial')->default(false);
            $table->smallInteger('max_number_of_clients')->unsigned();
            $table->smallInteger('duration')->unsigned();
            $table->float('extra_class_price')->unsigned();
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
        Schema::drop('class_types');
    }
}
