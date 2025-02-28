<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_inv_code');
            $table->unsignedBigInteger('from_location_id');
            $table->unsignedBigInteger('to_location_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('transfer_qty')->default(0);
            $table->unsignedBigInteger('stock_qty')->default(0);
            $table->string('status');
            $table->string('transfer_type');
            $table->string('remark')->nullable();
            $table->timestamp('transfer_date');
            $table->timestamps();

            $table->foreign('from_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('to_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_transfers');
    }
}
