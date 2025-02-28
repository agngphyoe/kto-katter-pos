<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paymentable_id');
            $table->string('paymentable_type');
            $table->unsignedBigInteger('paymentableby_id');
            $table->string('paymentableby_type');
            $table->unsignedBigInteger('payment_type')->nullable();
            $table->enum('payment_status', ['Ongoing', 'Complete'])->default('ongoing');
            $table->date('payment_date');
            $table->date('next_payment_date')->nullable();
            $table->unsignedBigInteger('amount')->default(0);
            $table->unsignedBigInteger('total_paid_amount')->default(0);
            $table->unsignedBigInteger('remaining_amount')->default(0);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::dropIfExists('paymentable');
    }
}
