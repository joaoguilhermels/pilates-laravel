<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTypeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_type_statuses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('class_type_id')->unsigned()->index();
            $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('cascade');

            $table->string('name');
            $table->boolean('charge_client')->default(false);
            $table->boolean('pay_professional')->default(false);
            $table->string('color');
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
        Schema::disableForeignKeyConstraints();
        Schema::drop('class_type_statuses');
        Schema::enableForeignKeyConstraints();
    }
}
