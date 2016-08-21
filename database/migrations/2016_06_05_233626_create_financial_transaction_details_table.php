<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('financial_transaction_id')->references('id')->on('financial_transaction')->unsigned();

            $table->integer('payment_method_id')->references('id')->on('payment_method');
            $table->integer('bank_account_id')->references('id')->on('bank_account')->nullable; //pagamento em dinheiro não precisa de banco
            $table->date('date');
            $table->float('value');
            $table->enum('type', ['received', 'paid']);
            $table->integer('payment_number')->unsigned()->default(1);

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
        Schema::drop('financial_transaction_details');
    }
}
