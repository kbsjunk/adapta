<?php

namespace Adapta\Components\Loaders;

use Ddeboer\DataImport\Reader\CsvReader;

class CsvLoader extends AbstractLoader implements LoaderInterface {

	protected $options = [
		'delimiter'  => ',',
		'enclosure'  => '"',
		'escape'     => '\\',
		'strict'     => true,
		'headers'    => null, // null, [], number, merge, increment
		'header_row' => 0, // false, 0, 1, 2...
	];

	public function load() {

		$reader = new CsvReader(
			$this->getFile(),
			$this->getOption('delimiter'),
			$this->getOption('enclosure'),
			$this->getOption('escape')
			);

		$headers   = $this->getOption('headers');
		$headerRow = $this->getOption('header_row');

		if (false !== $headerRow) {
			$duplicateHeaders = $headers == 'merge' ? CsvReader::DUPLICATE_HEADERS_MERGE : CsvReader::DUPLICATE_HEADERS_INCREMENT;
			$reader->setHeaderRowNumber($headerRow, $duplicateHeaders);
		}

		if (is_array($headers)) {
			$reader->setColumnHeaders($headers);
		}
		elseif ('number' == $headers) {
			$headers = [];

			for ($i=1; $i <= count($reader->getColumnHeaders()); $i++) { 
				$headers[] = 'field'.$i;
			}

			$reader->setColumnHeaders($headers);
		}

		$reader->setStrict($this->getOption('strict'));
		
		$this->setReader($reader);

	}
	
}