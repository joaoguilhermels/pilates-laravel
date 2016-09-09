<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            //$table->foreign('parent_id')->references('id')->on('schedules'); // This will be used to have related class like reposition

            $table->integer('client_id')->unsigned()->index();
            $table->foreign('client_id')->references('id')->on('clients');

            //$table->integer('client_plan_detail_id')->nullable()->unsigned()->index();
            $table->morphs('scheduable');

            $table->boolean('trial')->default(false);

            $table->integer('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('rooms');

            $table->integer('class_type_id')->unsigned()->index();
            $table->foreign('class_type_id')->references('id')->on('class_types');

            $table->integer('professional_id')->unsigned()->index();
            $table->foreign('professional_id')->references('id')->on('professionals');

            $table->integer('class_type_status_id')->unsigned()->index();
            $table->foreign('class_type_status_id')->references('id')->on('class_type_statuses');

            $table->float('price');
            $table->float('value_professional_receives');

            $table->integer('professional_payment_financial_transaction_id')->unsigned()->index()->nullable()->default(null); // foreign key added on 2016_09_09_160128_add_professional_payment_financial_transaction_id_foreign_key_to_schedules_table.php

            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->string('observation');

            // No need for this columns because we can track payments based off of the clientplandeatils and clientplan on the financialtransactions table
            //$table->integer('client_payment_financial_transaction_id')->unsigned()->index()->references('id')->on('financial_transactions');

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
        Schema::drop('schedules');
        Schema::enableForeignKeyConstraints();
    }
}
