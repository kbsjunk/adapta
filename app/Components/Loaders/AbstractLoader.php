<?php

namespace Adapta\Components\Loaders;

use SplFileObject;
use File;
use Adapta\Exceptions\FileNotFoundException;
use Ddeboer\DataImport\Reader\CountableReader as ReaderInterface;

abstract class AbstractLoader implements LoaderInterface {

	protected $class;

	protected $file;
	
	protected $reader;

	protected $data;

	protected $options = [];

	public function load() { }

	public function setFile($file) {

		$file = storage_path($file);

		if (File::exists($file)) {

			$this->file = new SplFileObject($file);

			return true;
		}

		throw new FileNotFoundException($file);

	}

	public function getFile()
	{
		return $this->file;
	}

	public function setReader($reader)
	{
		$this->reader = $reader;
	}

	public function getReader()
	{
		return $this->reader;
	}

	public function setOptions(array $options)
	{
		$this->options = array_merge($this->options, $options);
	}

	public function getOptions()
	{
		return (array) $this->options;
	}

	public function setOption($option, $value)
	{
		$this->options[$option] = $value;
	}

	public function getOption($option)
	{
		return @$this->options[$option];
	}
	
}