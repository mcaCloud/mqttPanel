<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->Increments('devices_id');
            $table->timestamps('devices_date');
            $table->string('devices_alias')->nullable();
            $table->string('devices_serie');
            $table->integer('devices_user_id')->unsigned()->nullable();

            $table->softDeletes();

            $table->foreign('devices_user_id')
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
        Schema::dropIfExists('devices');
    }
}
