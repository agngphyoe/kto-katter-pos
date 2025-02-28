<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceNumberToCashbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbooks', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('description');
            $table->string('employee_name')->nullable()->after('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashbooks', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
            $table->dropColumn('employee_name');
        });
    }
}
