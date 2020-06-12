<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('created_by_id')->unsigned()->nullable();

            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('req_data')->unsigned()->nullable();
            $table->boolean('completed')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['deleted_at']);

            $table->foreign('created_by_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folders');
    }
}
