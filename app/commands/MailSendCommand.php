<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MailSendCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mail:send';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sends scheduled mail.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$salt = md5(mt_rand(0, 65535));

		DB::table('emails')
			->where('status', 0)
			->take(100)
			->update([
				'status' => $salt
			]);

		$mail = DB::table('emails')
			->where('status', $salt)
			->take(100)
			->get();

		foreach ($mail as $letter) {
			/**/
			Mail::send($letter->template, unserialize($letter->data), function ($message) use ($letter)
			{
				$message->to('ssanja1@pride.hofstra.edu', 'Shashank Sanjay')->subject('Yo');//$letter->user_email, $letter->user_name)->subject($letter->subject);
			});
			/**/

			DB::table('emails')
				->where('id', $letter->id)
				->update([
					'status' => 2
				]);
		}
	}

}