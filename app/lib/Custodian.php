<?php

class Custodian
{

	public static function run()
	{
		//clean orders older than 24 hours
		self::clean('Order');

		//clean latesignups older than 24 hours
		self::clean('Latesignup');

		//clean notifications older than 24 hours
		self::clean('Notification');

		//check lesson spots & waitlist
		foreach (Waitlist::with('lesson.children', 'user')->get() as $waitlist) {
			$lesson = $waitlist->lesson;
			$spots	= $lesson->spots;
			$filled	= count($lesson->children()->get());
			$user 	= $waitlist->user;

			if ($filled < $spots) {
				//alert user they have 24 hours to sign up

				//create order object

				//create notification object
			}
		}
	}

	public static function clean($m)
	{
		$models = $m::all();

		foreach ($models as $model) {
			$created = new DateTime($model->created_at);
			$clock = (new DateTime)->modify('-1 day');

			if ($created < $clock) $model->delete();
		}
	} 

}
