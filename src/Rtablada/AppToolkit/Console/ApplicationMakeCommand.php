<?php namespace Rtablada\AppToolkit\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Rtablada\AppToolkit\ApplicationCreator;

class ApplicationMakeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'application:make';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a subapplication in your Laravel project.';

	/**
	 * Instance of ApplicationCreator
	 *
	 * @var Rtablada\AppToolkit\ApplicationCreator
	 */
	protected $applicationCreator;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ApplicationCreator $applicationCreator)
	{
		$this->applicationCreator = $applicationCreator;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$subAppName = studly_case($this->argument('app_name'));

		// Get extra arguments
		$this->applicationCreator->create($subAppName);
		$this->info('Application created!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('app_name', InputArgument::REQUIRED, 'Name of the sub-application.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
