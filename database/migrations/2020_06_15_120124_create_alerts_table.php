<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('public')->default(0);
            $table->string('image')->nullable();
            $table->string('alert_path')->nullable();

            $table->timestamps();
            $table->softDeletes();

                $table->index(['deleted_at']);

                $table->foreign('user_id')
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
        Schema::dropIfExists('alerts');
    }
}
