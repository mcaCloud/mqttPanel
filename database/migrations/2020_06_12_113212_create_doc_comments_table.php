<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_comments', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable();

            $table->integer('doc_id')->unsigned()->nullable();

            $table->string('body');

            $table->timestamps();

            $table->softDeletes();

            $table->index(['deleted_at']);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('doc_id')
                  ->references('id')
                  ->on('docs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_comments');
    }
}
