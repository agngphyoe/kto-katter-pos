<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointOfSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_of_sale_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('point_of_sale_id')->references('id')->on('point_of_sales')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('unit_price');
            $table->bigInteger('quantity');
            $table->boolean('is_promote')->default(false);
            $table->foreignId('promotion_id')->nullable()->references('id')->on('promotions')->onDelete('cascade');
            $table->bigInteger('price');
            $table->json('imei')->nullable();
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
        Schema::dropIfExists('point_of_sale_products');
    }
}
