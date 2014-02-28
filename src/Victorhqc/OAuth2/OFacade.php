<?php namespace Victorhqc\OAuth2;

use Illuminate\Support\Facades\Facade;

class OFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'oauth2server'; }

}

?>