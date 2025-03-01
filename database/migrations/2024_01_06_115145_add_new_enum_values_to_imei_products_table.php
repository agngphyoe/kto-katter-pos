<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewEnumValuesToImeiProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imei_products', function (Blueprint $table) {
            \DB::statement("ALTER TABLE `imei_products` CHANGE `status` `status` ENUM('Available','Sold','Repair', 'Damage', 'Sale_Return', 'Purchase_Return') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imei_products', function (Blueprint $table) {
            //
        });
    }
}
