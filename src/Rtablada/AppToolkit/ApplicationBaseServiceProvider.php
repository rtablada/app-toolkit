<?php namespace Rtablada\AppToolkit;

use Illuminate\Support\ServiceProvider;

class ApplicationBaseServiceProvider extends ServiceProvider
{
	/**
	 * Should routes be booted?
	 *
	 * @var boolean
	 */
	protected $routes = true;

	/**
	 * Should filters be booted?
	 *
	 * @var boolean
	 */
	protected $filters = false;

	/**
	 * Should views be booted and what is their namespace?
	 *
	 * @var string
	 */
	protected $viewNamespace = null;

	/**
	 * We need this to know the location of our child class.
	 *
	 * @var boolean
	 */
	protected $fileLocation = __DIR__;

	/**
	 * Service Provider Register function - User extendable
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Boot our routes, filters, and views.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->bootRoutes();
		$this->bootFilters();
		$this->bootViews();
	}

	/**
	 * Boot routes file.
	 *
	 * @return void
	 */
	public function bootRoutes()
	{
		if ($this->routes) {
			require_once($this->fileLocation.'/../routes.php');
		}
	}

	/**
	 * Boot filters file.
	 *
	 * @return void
	 */
	public function bootFilters()
	{
		if ($this->filters) {
			require_once($this->fileLocation.'/../filters.php');
		}
	}

	/**
	 * Boot views namespace.
	 *
	 * @return void
	 */
	public function bootViews()
	{
		if ($this->viewNamespace) {
			$this->app['view']->addNamespace($this->viewNamespace, $this->fileLocation.'/../views');
		}
	}
}
