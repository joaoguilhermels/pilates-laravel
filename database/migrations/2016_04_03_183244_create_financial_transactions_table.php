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
            
            $table->integer('entity_id');
            $table->string('entity_type');
            $table->enum('type', array('received', 'paid'));

            $table->integer('payment_method_id');
            $table->integer('bank_account_id')->nullable; //pagamento em dinheiro não precisa de banco
            $table->date('date');
            $table->float('value');
            $table->integer('payment_number');
            $table->integer('total_number_of_payments');

            $table->integer('status'); // Confirmado, aguardando
            $table->float('confirmed_value');
            $table->float('confirmed_date');
            $table->string('observation');

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
