<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_comments', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable();

            $table->integer('video_id')->unsigned()->nullable();

            $table->string('body');

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
        Schema::dropIfExists('video_comments');
    }
}
