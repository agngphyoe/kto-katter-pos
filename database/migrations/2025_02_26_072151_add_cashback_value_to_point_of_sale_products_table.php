<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashbackValueToPointOfSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_of_sale_products', function (Blueprint $table) {
            $table->bigInteger('cashback_amount')->after('origin_price')->nullable();
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
            $table->dropColumn('cashback_amount');
        });
    }
}
