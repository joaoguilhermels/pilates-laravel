<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('financiable');

            $table->string('name');

            $table->enum('type', array('received', 'paid'));

            $table->integer('total_number_of_payments')->unsigned()->default(1);

            $table->string('observation')->nullable;

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
        Schema::drop('financial_transactions');
    }
}
