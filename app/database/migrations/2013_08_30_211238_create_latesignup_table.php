<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLatesignupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('latesignups', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email');
			$table->string('child_name');
			$table->integer('session_id');
			$table->integer('user_id')->nullable();
			$table->integer('child_id')->nullable();
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
		Schema::drop('latesignups');
	}

}
