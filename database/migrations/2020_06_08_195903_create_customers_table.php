<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('account_id');
            $table->string('image')->nullable();
            $table->string('notification_preference')->default('mail');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('father_surname')->nullable();
            $table->string('mother_surname')->nullable();
            $table->string('email')->unique();
            $table->string('email1')->nullable();;
            $table->boolean('gender')->default(0);
            $table->string('studies')->nullable();
            $table->string('interest')->nullable();

            $table->string('facebook_acct_id')->unique()->nullable();
            $table->string('instagram_accnt_id')->unique()->nullable();
            $table->string('country_birth')->nullable();

            $table->integer('phone')->nullable();
            $table->integer('phone_emergency')->nullable();

            $table->dateTime('birthdate')->nullable();

            $table->boolean('access_web')->default(0);
            $table->boolean('access_app')->default(0);

            $table->boolean('hidden')->default(0);
            $table->string('password');

            $table->dateTime('last_login')->nullable();
            $table->rememberToken();

            $table->string('street')->nullable();
            $table->string('street1')->nullable();
            $table->string('city')->nullable();
            $table->string('city1')->nullable();
            $table->integer('zipcode')->nullable();
            $table->integer('zipcode1')->nullable();
            $table->string('contry')->nullable();
            $table->string('contry1')->nullable();

            $table->integer('created_by_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['deleted_at']);

            $table->foreign('created_by_id')
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
        Schema::dropIfExists('customers');
    }
}
