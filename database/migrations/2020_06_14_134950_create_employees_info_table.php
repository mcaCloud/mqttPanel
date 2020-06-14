<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_info', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id');

            $table->boolean('gender')->default(0);
            $table->string('studies')->nullable();
            $table->string('interest')->nullable();

            $table->string('facebook_acct_id')->unique()->nullable();
            $table->string('instagram_accnt_id')->unique()->nullable();

            $table->integer('phone')->nullable();
            $table->integer('phone_emergency')->nullable();

            $table->date('birthdate')->nullable();
            $table->string('cityOfBirth')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->integer('zipcode')->nullable();
            $table->string('country')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['deleted_at']);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_info');
    }
}
