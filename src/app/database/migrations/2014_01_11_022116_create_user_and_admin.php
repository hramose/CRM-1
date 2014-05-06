<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserAndAdmin extends Migration {


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function ($table) {
        $table->increments('id');
        $table->string('email')->unique();
        $table->string('name');
        $table->timestamps();
      });


      Schema::create('admins', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('password');
        $table->string('email')->unique();
        $table->timestamps();
      });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('admins');
    }


}