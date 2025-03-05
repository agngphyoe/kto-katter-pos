<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockReconciliationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_reconciliation_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_reconciliation_id')->references('id')->on('stock_reconciliations')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('inv_qty')->unsigned();
            $table->integer('real_qty')->unsigned();
            $table->integer('diff')->nullable();
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
        Schema::dropIfExists('stock_reconciliation_products');
    }
}
