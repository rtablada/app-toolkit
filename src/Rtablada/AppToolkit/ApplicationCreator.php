<?php namespace Rtablada\AppToolkit;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;

class ApplicationCreator
{

	/**
	 * Filesystem instance
	 *
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * Config instance
	 *
	 * @var Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Parent Application Name
	 *
	 * @var string
	 */
	protected $appName;

	/**
	 * Should a routes file be created and included in the service provider?
	 *
	 * @var boolean
	 */
	protected $routes = true;

	/**
	 * Should a filters file be created and included in the service provider?
	 *
	 * @var boolean
	 */
	protected $filters = false;

	public function __construct(Filesystem $files, Config $config)
	{
		$this->files = $files;
		$this->appName = $config->get('app-toolkit::app_name');
	}

	public function create($subAppName, array $options = array())
	{
		$this->setOptions($options);

		$directory = $this->createDirectory($subAppName);
		$this->createRoutes($directory);
		$this->createFilters($directory);
		// $this->createViews($directory);
	}

	public function createDirectory($subAppName)
	{
		$directory = app_path().'/'.$this->appName.'/Applications/'.$subAppName;
		if (!$this->files->isDirectory($directory)) {
			$this->files->makeDirectory($directory, 0777, true);
		}
		return $directory;
	}

	public function createRoutes($directory)
	{
		if ($this->routes) {
			$this->files->put($directory.'/routes.php', '<?php');
		}
	}

	public function createFilters($directory)
	{
		if ($this->filters) {
			$this->files->put($directory.'/filters.php', '<?php');
		}
	}

	public function setOptions(array $options)
	{

	}

}
