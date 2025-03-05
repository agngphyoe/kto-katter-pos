<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_number')->unique()->nullable();
            $table->string('name')->unique()->index();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('nrc')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('slug')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->text('image')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
