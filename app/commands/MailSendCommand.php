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
		Log::info('Running @ '.(new DateTime)->format('H:i:s'));

		$salt = md5(mt_rand(0, 65535));

		 $this->info('Salting ...');

		DB::table('emails')
			->where('status', '0')
			->take(100)
			->update([
				'status' => $salt
			]);

		sleep(10);

		$mail = DB::table('emails')
			->where('status', $salt)
			->take(100)
			->get();

		if ($mail) {
			 $this->info(" Salted!\n");
		} else {
			 $this->info(" Salting failed.\n");
		}

		foreach ($mail as $letter) {

			$user = User::where('email', $letter->user_email)->first();
			$subscribed = ($user) ? $user->subscribed : true;

			 $this->info('Sending ...');

			/**/
			if ( ! Donotmail::thisAddress($letter->user_email) && $subscribed) {
				Mail::send($letter->template, unserialize($letter->data), function ($message) use ($letter)
				{
					$message->to($letter->user_email, $letter->user_name)->subject($letter->subject);
				});
				 $this->info(' Sent!'."\n");
			} else {
				 $this->info(' Could not be sent.'."\n");
			}
			/**/


			DB::table('emails')
				->where('id', $letter->id)
				->update([
					'status' => 2
				]);
		}
	}

}