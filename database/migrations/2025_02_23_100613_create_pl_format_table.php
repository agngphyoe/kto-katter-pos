<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pl_format', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['revenue', 'cogs', 'other_incomes', 'expenses']);
            $table->enum('status', ['add', 'less']);
            $table->enum('action_type', ['auto', 'manual']);
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
        Schema::dropIfExists('pl_format');
    }
}
