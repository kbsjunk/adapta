<?php

namespace Adapta\Components\Loaders;

use Adapta\Exceptions\LoaderNotExistException;

class LoaderFactory {
	
	private $loaders = [
		'csv'   => CsvLoader::class,
		'json'  => JsonLoader::class,
		'yaml'  => YamlLoader::class,
		'excel' => ExcelLoader::class,
		'tab'   => TabLoader::class,
	];
	
	public function make($loader)
	{
		if ($this->hasLoader($loader))
		{
			$class = array_get($this->loaders, $loader);
			
			return new $class;
		}
		
		throw new LoaderNotExistException($loader);
	}
	
	public function hasLoader($loader)
	{
		return array_key_exists($loader, $this->loaders);
	}
	
}