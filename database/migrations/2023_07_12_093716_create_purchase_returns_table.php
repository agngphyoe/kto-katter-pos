<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string('remark')->nullable();
            $table->foreignId('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->date('return_date');
            $table->unsignedBigInteger('return_quantity');
            $table->unsignedBigInteger('return_amount');
            $table->unsignedBigInteger('old_purchase_amount');
            $table->unsignedBigInteger('new_purchase_amount');
            $table->foreignId('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('purchase_returns');
    }
}
