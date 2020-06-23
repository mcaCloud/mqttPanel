<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('created_by_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('folder_id')->unsigned()->nullable();
            

            $table->string('description')->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_number')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('floor_door')->nullable();
            $table->string('floor_letter')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('manual_directions')->nullable();

            $table->string('metro_station_1')->nullable();
            $table->string('metro_line_1')->nullable();
            $table->string('metro_station_2')->nullable();
            $table->string('metro_line_2')->nullable();
            $table->integer('bus_line')->nullable();
            $table->string('bus_line_letter')->nullable();
            $table->string('renfe_line')->nullable();
            $table->string('renfe_line_letter')->nullable();
            $table->string('schedule_days')->nullable();
            $table->string('schedule_hours')->nullable();          
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();


            $table->boolean('appt_req')->default(0);            
            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('offices');
    }
}
