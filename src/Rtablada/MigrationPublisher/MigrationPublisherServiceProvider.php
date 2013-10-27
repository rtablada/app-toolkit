<?php namespace Rtablada\MigrationPublisher;

use Illuminate\Support\ServiceProvider;

class MigrationPublisherServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->package('rtablada/migration-publisher');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['command.migrate.publish'] = $this->app->share(function($app)
		{
			$packagePath = $app['path.base'].'/vendor';

			return new MigrationPublisherCommand($app['files'], $packagePath);
		});

		$this->commands('command.migrate.publish');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.migrate.publish');
	}

}
