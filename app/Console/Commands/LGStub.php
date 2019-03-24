<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class LGStub extends GeneratorCommand
{
	/**
	* The name and signature of the console command.
	*
	* @var string
	*/
	protected $name = 'lg:stub';

	/**
	* The console command description.
	*
	* @var string
	*/
	protected $description = 'Don\'t use this command. Run lg:crud {name} instead';

	/**
	* The type of class being generated.
	*
	* @var string
	*/
	// protected $type = 'View';

	/**
	* Replace the class name for the given stub.
	*
	* @param  string  $stub
	* @param  string  $name
	* @return string
	*/
	protected function replaceClass($stub, $name)
	{
		$search = [
			'DummyArray',
			'DummyAttribute',
			'DummyClass',
			'DummyController',
			'DummyEvent',
			'DummyField',
			'DummyLabel',
			'DummyMigration',
			'DummyMigrationClass',
			'DummyMigrationTable',
			'DummyModel',
			'DummyRepository',
			'DummyRepoVariable',
			'DummyRequest',
			'DummyRoute',
			'DummyTable',
			'DummyVariable',
			'DummyView',
		];

		$replace = [
			$this->argument('array'),
			$this->argument('attribute'),
			$this->argument('class'),
			$this->argument('controller'),
			$this->argument('event'),
			$this->argument('field'),
			$this->argument('label'),
			$this->argument('migration'),
			$this->argument('migrationClass'),
			$this->argument('migrationTable'),
			$this->argument('model'),
			$this->argument('repository'),
			$this->argument('repositoryVariable'),
			$this->argument('request'),
			$this->argument('route'),
			$this->argument('table'),
			$this->argument('variable'),
			$this->argument('view'),
		];

		return str_replace( $search, $replace, $stub );
	}

	/**
	* Get the stub file for the generator.
	*
	* @return string
	*/
	protected function getStub()
	{
		return $this->argument('stub');
	}

	/**
	* Get the default namespace for the class.
	*
	* @param  string  $rootNamespace
	* @return string
	*/
	protected function getDefaultNamespace($rootNamespace)
	{
		return $rootNamespace . $this->argument('namespace');
	}

	/**
	* Get the console command arguments.
	*
	* @return array
	*/
	protected function getArguments()
	{
		return [
			['name', 				InputArgument::REQUIRED, 'File name'],
			['stub', 				InputArgument::REQUIRED, 'Stub name'],
			['namespace', 			InputArgument::REQUIRED, 'Namespace'],
			['array',				InputArgument::OPTIONAL, 'Array name', null],
			['attribute',			InputArgument::OPTIONAL, 'Attribute name', null],
			['class',				InputArgument::OPTIONAL, 'Class name', null],
			['controller',			InputArgument::OPTIONAL, 'Controller name', null],
			['event',				InputArgument::OPTIONAL, 'Event name', null],
			['field',				InputArgument::OPTIONAL, 'Field name', null],
			['label',				InputArgument::OPTIONAL, 'Label name', null],
			['migration',			InputArgument::OPTIONAL, 'Migration name', null],
			['migrationClass',		InputArgument::OPTIONAL, 'MigrationClass name', null],
			['migrationTable',		InputArgument::OPTIONAL, 'MigrationTable name', null],
			['model',				InputArgument::OPTIONAL, 'Model name', null],
			['repository',			InputArgument::OPTIONAL, 'Repository name', null],
			['repositoryVariable',	InputArgument::OPTIONAL, 'Repository variable name', null],
			['request',				InputArgument::OPTIONAL, 'Request name', null],
			['route',				InputArgument::OPTIONAL, 'Route name', null],
			['table',				InputArgument::OPTIONAL, 'Table name', null],
			['variable',			InputArgument::OPTIONAL, 'Variable name', null],
			['view',				InputArgument::OPTIONAL, 'View name', null],
		];
	}
}
