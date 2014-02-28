<?php namespace Victorhqc\OAuth2;

use Illuminate\Support\ServiceProvider;
use OAuth2;

class OAuth2ServiceProvider extends ServiceProvider {

/**
* Register the service provider.
*
* @return void
*/
public function register()
{
	// Register 'underlyingclass' instance container to our UnderlyingClass object
	$this->app['oauth2server'] = $this->app->share(function($app)
	{
		OAuth2\Autoloader::register();

		$storage = new OAuth2\Storage\Pdo(array('dsn' => "mysql:host=localhost;dbname=db_name", 'username' => "root", 'password' => "somepassword"));

		// Pass a storage object or array of storage objects to the OAuth2 server class
		$config = array('allow_implicit' => true, 'access_lifetime' => 3600 * 24 * 7 * 3); // 3 weeks duration
		$server = new OAuth2\Server($storage, $config);

		// Add the "Client Credentials" grant type (it is the simplest of the grant types)
		$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

		// Add the "Authorization Code" grant type (this is where the oauth magic happens)
		$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

		return $server;
	});

	// Shortcut so developers don't need to add an Alias in app/config/app.php
	$this->app->booting(function()
	{
		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('Oauth2Server', 'Victorhqc\OAuth2\OFacade');
	});
	}
}