<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\CurrencyType;

class AddCurrencyValuesToPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('currency_type')->default(CurrencyType::Kyat->value)->after('supplier_id');
            $table->unsignedBigInteger('currency_rate')->default(0)->after('currency_type');
            $table->unsignedBigInteger('currency_purchase_amount')->default(0)->after('currency_rate');
            $table->unsignedBigInteger('currency_discount_amount')->default(0)->after('currency_purchase_amount');
            $table->unsignedBigInteger('currency_net_amount')->default(0)->after('currency_discount_amount');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('currency_type');
            $table->dropColumn('currency_rate');
            $table->dropColumn('currency_purchase_amount');
            $table->dropColumn('currency_discount_amount');
            $table->dropColumn('currency_net_amount');
        });
    }
}
