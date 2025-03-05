<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginValuesToPointOfSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_of_sale_products', function (Blueprint $table) {
            $table->unsignedBigInteger('origin_quantity')->nullable()->after('unit_price');
            $table->unsignedBigInteger('origin_price')->nullable()->after('promotion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('point_of_sale_products', function (Blueprint $table) {
            $table->dropColumn('origin_quantity');
            $table->dropColumn('origin_price');
        });
    }
}
