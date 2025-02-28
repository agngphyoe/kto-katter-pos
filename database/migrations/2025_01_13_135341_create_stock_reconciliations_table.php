<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockReconciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->string('reconciliation_id');
            $table->foreignId('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->date('reconciliation_date');
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('stock_reconciliations');
    }
}
