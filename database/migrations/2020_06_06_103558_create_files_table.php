<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
                $table->string('uuid')->nullable();
                $table->string('file_path')->nullable();
                $table->string('filename')->nullable();
                $table->integer('folder_id')->unsigned()->nullable();
                $table->integer('product_id')->unsigned()->nullable();
                $table->boolean('status')->default(0);
                $table->integer('created_by_id')->unsigned()->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);

                $table->foreign('folder_id')
                      ->references('id')
                      ->on('folders')
                      ->onDelete('cascade');


                $table->foreign('created_by_id')
                      ->references('id')
                      ->on('users')
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
        Schema::dropIfExists('files');
    }
}
