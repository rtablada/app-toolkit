<?php namespace Rtablada\AppToolkit;

use Illuminate\Support\ServiceProvider;

class ApplicationBaseServiceProvider extends ServiceProvider
{
	protected $routes = true;
	protected $filters = false;
	protected $viewNamespace = null;
	protected $fileLocation = __DIR__;

	public function register()
	{

	}

	public function boot()
	{
		$this->bootRoutes();
		$this->bootFilters();
		$this->bootViews();
	}

	public function bootRoutes()
	{
		if ($this->routes) {
			require_once($this->fileLocation.'/../routes.php');
		}
	}

	public function bootFilters()
	{
		if ($this->filters) {
			require_once($this->fileLocation.'/../filters.php');
		}
	}

	public function bootViews()
	{
		if ($this->viewNamespace) {
			View::addNamespace($this->viewNamespace, $this->fileLocation.'/../views');
		}
	}
}
