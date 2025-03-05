<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->foreignId('buy_product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedBigInteger('buy_wholesale_price')->nullable();
            $table->unsignedBigInteger('buy_retail_price')->nullable();
            $table->unsignedBigInteger('buy_quantity')->nullable();
            $table->foreignId('get_product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->unsignedBigInteger('get_wholesale_price')->nullable();
            $table->unsignedBigInteger('get_retail_price')->nullable();
            $table->unsignedBigInteger('get_quantity')->nullable();
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
        Schema::dropIfExists('promotion_products');
    }
}
