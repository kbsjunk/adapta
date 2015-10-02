<?php

namespace Adapta\Components\Loaders;

use Adapta\Exceptions\LoaderNotExistException;

class LoaderFactory {
	
	private static $loaders = [
		'csv'   => CsvLoader::class,
		'json'  => JsonLoader::class,
		'yaml'  => YamlLoader::class,
		'excel' => ExcelLoader::class,
		'tab'   => TabLoader::class,
	];
	
	public static function make($loader, $content = null)
	{
		if (self::hasLoader($loader))
		{
			$class = array_get(self::$loaders, $loader);
			
			return new $class($content);
		}
		
		throw new LoaderNotExistException($loader);
	}
	
	public static function hasLoader($loader)
	{
		return array_key_exists($loader, self::$loaders);
	}
	
}