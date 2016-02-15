<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassTypeRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_type_room', function (Blueprint $table) {
            $table->integer('class_type_id')->unsigned()->index();
            $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('cascade');
            
            $table->integer('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            
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
        Schema::drop('class_type_room');
    }
}
