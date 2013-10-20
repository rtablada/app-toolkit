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
	 * Options when creating application
	 *
	 * @var boolean
	 */
	protected $options = array(
		'routes' => true,
		'filters' => false,
	);

	public function __construct(Filesystem $files, Config $config)
	{
		$this->files = $files;
		$this->appName = $config->get('app-toolkit::app_name');
	}

	public function create($subAppName, array $options = array())
	{
		$this->options['viewNamespace'] = $subAppName;
		$this->setOptions($options);

		$directory = $this->createDirectory($subAppName);
		$this->createRoutes($directory);
		$this->createFilters($directory);
		$this->createViews($directory);

		$this->createServiceProvider($subAppName, $directory);
	}

	protected function createDirectory($subAppName)
	{
		$directory = app_path().'/'.$this->appName.'/Applications/'.$subAppName;
		if (!$this->files->isDirectory($directory)) {
			$this->files->makeDirectory($directory, 0777, true);
		}
		return $directory;
	}

	protected function createRoutes($directory)
	{
		if ($this->options['routes']) {
			$this->files->put($directory.'/routes.php', '<?php');
		}
	}

	protected function createViews($directory)
	{
		if ($this->options['viewNamespace']) {
			$viewsDirectory = $directory.'/views';
			if (!$this->files->isDirectory($viewsDirectory)) {
				$this->files->makeDirectory($viewsDirectory, 0777, true);
			}
		}
	}

	protected function createServiceProvider($subAppName, $directory)
	{
		$serviceProviderDirectory = $this->createServiceProviderDirectory($subAppName, $directory);

		$stub = $this->files->get(__DIR__.'/stubs/ServiceProvider.stub');
		$stub = str_replace('{{ $routes }}', $this->getStringValue($this->options['routes']) , $stub);
		$stub = str_replace('{{ $filters }}', $this->getStringValue($this->options['filters']) , $stub);
		$stub = str_replace('{{ $viewNamespace }}', $this->getStringValue($this->options['viewNamespace']) , $stub);

		$this->files->put($serviceProviderDirectory.'/'.$subAppName.'.php', $stub);
	}

	protected function createServiceProviderDirectory($subAppName, $directory)
	{
		$serviceProviderDirectory = $directory.'/ServiceProviders';
		if (!$this->files->isDirectory($serviceProviderDirectory)) {
			$this->files->makeDirectory($serviceProviderDirectory, 0777, true);
		}

		return $serviceProviderDirectory;
	}

	protected function createFilters($directory)
	{
		if ($this->options['filters']) {
			$this->files->put($directory.'/filters.php', '<?php');
		}
	}

	protected function setOptions(array $options)
	{
		$this->options = array_merge($this->options, $options);
	}

	protected function getStringValue($var)
	{
		if (is_bool($var)) {
			return $var ? 'true' : 'false';
		}
		return $var;
	}

}
