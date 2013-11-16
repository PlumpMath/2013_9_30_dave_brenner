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
			$table->integer('lesson_id');
			$table->string('email')->nullable();
			$table->integer('user_id')->nullable();
			$table->string('child_name')->nullable();
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
