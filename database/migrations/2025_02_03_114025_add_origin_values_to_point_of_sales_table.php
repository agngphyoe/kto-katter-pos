<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginValuesToPointOfSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_of_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('origin_quantity')->nullable()->after('location_id');
            $table->unsignedBigInteger('origin_amount')->nullable()->after('total_quantity');
            $table->unsignedBigInteger('origin_net_amount')->nullable()->after('discount_amount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('point_of_sales', function (Blueprint $table) {
            $table->dropColumn('origin_quantity');
            $table->dropColumn('origin_amount');
            $table->dropColumn('origin_net_amount');
        });
    }
}
