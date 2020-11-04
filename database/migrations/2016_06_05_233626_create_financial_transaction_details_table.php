<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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

            $table->integer('financial_transaction_id')->unsigned()->index();

            $table->integer('payment_method_id')->unsigned()->index();

            $table->integer('bank_account_id')->unsigned()->index()->nullable(); //pagamento em dinheiro não precisa de banco

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
