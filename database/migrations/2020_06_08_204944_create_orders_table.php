<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('access_web')->default(0);
            $table->integer('created_by_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('completed')->default(0);
            $table->integer('req_data')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['deleted_at']);

            $table->foreign('created_by_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('customers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
