<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssueDateToCashbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbooks', function (Blueprint $table) {
            $table->date('issue_date')->nullable()->after('employee_name');;
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
            $table->date('issue_date')->nullable()->after('employee_name');;
        });
    }
}
