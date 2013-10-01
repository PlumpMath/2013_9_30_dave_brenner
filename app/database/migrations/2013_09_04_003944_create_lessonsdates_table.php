<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLessonsdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson_dates', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('lesson_id');
			$table->integer('lesson_date_template_id')->nullable;
			$table->string('name')->nullable;
			$table->text('description')->nullable;
			$table->timestamp('starts_on');
			$table->timestamp('ends_on');			
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
		Schema::drop('lesson_dates');
	}

}
