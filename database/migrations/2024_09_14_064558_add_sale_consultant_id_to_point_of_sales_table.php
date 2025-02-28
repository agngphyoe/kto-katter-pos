<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleConsultantIdToPointOfSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_of_sales', function (Blueprint $table) {
            $table->foreignId('sale_consultant_id')->nullable()->constrained('sale_consultants')->onDelete('set null');
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
            $table->dropColumn('sale_consultant_id');
        });
    }
}
