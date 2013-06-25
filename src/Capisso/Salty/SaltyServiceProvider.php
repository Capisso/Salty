<?php namespace Capisso\Salty;

use Illuminate\Support\ServiceProvider;

class SaltyServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('capisso/salty');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		\App::bind('salty', function()
		{
			$masterHost = \Config::get('salt.host');
			$masterPort = \Config::get('salt.port');
			$credentials = \Config::get('salt.credentials');
			$authType = \Config::get('salt.auth_type');
			$validation = \Config::get('salt.api_certificate_path');

			$api = new SaltApi(
				$masterHost, $masterPort, $authType, $credentials, $validation
			);

			return new SaltApiBuilder($api);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
