<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinancialTransactionIdForeignKeyToFinancialTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_transaction_details', function (Blueprint $table) {
            $table->foreign('financial_transaction_id')->references('id')->on('financial_transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_transaction_details', function (Blueprint $table) {
            $table->dropForeign(['financial_transaction_id']);
        });
    }
}
