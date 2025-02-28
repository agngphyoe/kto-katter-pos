<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->index();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('purchase_amount')->default(0);
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->unsignedBigInteger('total_retail_selling_amount')->default(0);
            $table->unsignedBigInteger('total_wholesale_selling_amount')->default(0);
            $table->unsignedBigInteger('total_quantity')->default(0);
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('total_return_quantity')->default(0);
            $table->unsignedBigInteger('total_return_buying_amount')->default(0);
            $table->unsignedBigInteger('total_return_retail_selling_amount')->default(0);
            $table->unsignedBigInteger('total_return_wholesale_selling_amount')->default(0);
            $table->boolean('return_status', [0, 1])->default(1);
            $table->string('payment_type')->nullable();
            $table->enum('action_type', ['Cash', 'Credit'])->default('Cash')->index();
            $table->date('action_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('cash_down')->default(0);
            $table->unsignedBigInteger('total_paid_amount')->default(0);
            $table->unsignedBigInteger('remaining_amount')->default(0);
            $table->enum('purchase_status', ['Ongoing', 'Complete'])->default('Ongoing');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('stock_status', ['Added', 'Remaining'])->default('Remaining');
            $table->integer('return_count')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
