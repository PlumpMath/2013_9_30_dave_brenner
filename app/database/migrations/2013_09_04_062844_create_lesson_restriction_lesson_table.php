<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLessonRestrictionLessonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson_lesson_restriction', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('lesson_id');
			$table->integer('lesson_restriction_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lesson_lesson_restriction');
	}

}
