<?php

namespace Adapta\Components\Loaders;

use Ddeboer\DataImport\Reader\CsvReader;

class CsvLoader extends AbstractLoader implements LoaderInterface {

	protected $options = [
		'delimiter'         => ',',
		'enclosure'         => '"',
		'escape'            => '\\',
		'strict'            => true,
		'duplicate_headers' => CsvReader::DUPLICATE_HEADERS_INCREMENT
	];

	protected $class = CsvReader::class;

	public function __construct($file) {

		$this->setFile($file);
		
		$this->setReader(new CsvReader($this->getFile()));

	}
	
}