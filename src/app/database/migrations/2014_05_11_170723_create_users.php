<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function ($table) {
            $table->increments('id');
            $table->string('email', 50)->unique();
            $table->string('username', 20)->unique();
            $table->string('password', 60);
            $table->string('password_temp', 60);
            $table->string('code', 60);
            $table->boolean('active');
            $table->integer('groups_id');
            $table->boolean('group_admin');
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
	}

}
