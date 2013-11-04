<?php namespace Williamstein92\QueryString\Facades;

use Illuminate\Support\Facades\Facade;

class QueryString extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'querystring'; }

}