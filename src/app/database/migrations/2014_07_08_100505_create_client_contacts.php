<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientContacts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_contacts', function ($table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->string('name');
            $table->string('mail');
            $table->string('phone');
            $table->string('address');
            $table->string('position');
            $table->dateTime('birth');
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
		Schema::drop('client_contacts');
	}

}
