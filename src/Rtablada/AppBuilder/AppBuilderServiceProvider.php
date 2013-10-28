<?php namespace Rtablada\AppBuilder;

use Illuminate\Support\ServiceProvider;
use Rtablada\AppBuilder\Console\ApplicationMakeCommand;

class AppBuilderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->package('rtablada/app-builder');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['app-builder.creator'] = $this->app->share(function($app)
		{
			return new ApplicationCreator($app['files'], $app['config']);
		});

		$this->app['command.application.make'] = $this->app->share(function($app)
		{
			return new ApplicationMakeCommand($app['app-builder.creator']);
		});

		$this->commands('command.application.make');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('app-builder.creator');
	}

}
