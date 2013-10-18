<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GetOlderCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'older';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checks and updates child ages.';

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
		foreach (Child::all() as $child) {
			//notify parent to update child's grade
			$data = [];
			
			$notification = new Notification;
			$notification->user_id = $child->user->id;
			$notification->data = serialize($data);
			$notification->template = "older";

			$notification->save();
		}
	}
}