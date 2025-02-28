<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitAndLossesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profit_and_losses', function (Blueprint $table) {
            $table->id();
            $table->string('profit_and_loss_number');
            $table->string('month');
            $table->bigInteger('sale');
            $table->bigInteger('sale_return');
            $table->bigInteger('sale_discount');
            $table->bigInteger('total_sales');
            $table->bigInteger('purchase_amount');
            $table->bigInteger('purchase_return_amount');
            $table->bigInteger('start_price');
            $table->bigInteger('end_price');
            $table->bigInteger('total_cost_of_sales');
            $table->bigInteger('gross_profit_on_sales');
            $table->bigInteger('incomes');
            $table->bigInteger('total_other_income');
            $table->bigInteger('total_gross_profit');
            $table->bigInteger('expenses');
            $table->bigInteger('total_expenses');
            $table->bigInteger('net_profit_before_tax');
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('profit_and_losses');
    }
}
