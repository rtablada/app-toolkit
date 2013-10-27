<?php namespace Rtablada\MigrationPublisher;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrationPublisherCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'migrate:publish';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publish a migration from a package.';

	/**
	 * The filesystem instance.
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	protected $packagePath;

	/**
	 * Create a new reminder table command instance.
	 *
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 * @return void
	 */
	public function __construct(Filesystem $files, $packagePath)
	{
		parent::__construct();

		$this->files = $files;
		$this->packagePath = $packagePath;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Get the migration files for the
		$filePaths = $this->getPackageMigrationFiles();

		// Publish each migration
		foreach ($filePaths as $filePath) {
			$this->publishMigration($filePath);
		}

		$this->info('Migrations published successfully!');

		$this->call('dump-autoload');
	}

	public function getPackageMigrationFiles()
	{
		$package = $this->argument('package');
		$migrationsDirectory = $this->packagePath.'/'.$package.'/src/migrations';

		return $this->files->files($migrationsDirectory);
	}

	public function publishMigration($filePath)
	{
		if ($this->files->extension($filePath) === 'php') {
			$fullPath = $this->createBaseMigration($filePath);

			$originalMigration = $this->files->get($filePath);

			$this->files->put($fullPath, $originalMigration);
		}
	}

	/**
	 * Create a base migration file for the reminders.
	 *
	 * @return string
	 */
	protected function createBaseMigration($filePath)
	{
		$name = str_replace('.php', '', preg_replace('/[\d_]+_/', '', basename($filePath)));

		$path = $this->laravel['path'].'/database/migrations';

		return $this->laravel['migration.creator']->create($name, $path);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('package', InputArgument::REQUIRED, 'The package to publish migrations.'),
		);
	}

}
