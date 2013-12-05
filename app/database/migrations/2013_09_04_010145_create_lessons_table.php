<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lessons', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('location_id');
            $table->integer('activity_id');
            $table->integer('section_id')->nullable;
            $table->integer('previous_id')->nullable;
            $table->string('provider')->nullable;
            $table->string('session_id')->nullable;
            $table->integer('spots');
            $table->decimal('price', 5, 2);
            $table->boolean('active');
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
		Schema::drop('lessons');
	}

}
