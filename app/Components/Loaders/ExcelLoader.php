<?php

namespace Adapta\Components\Loaders;

use Ddeboer\DataImport\Reader\ExcelReader;

class ExcelLoader extends AbstractFileLoader implements LoaderInterface
{
    protected $options = [
        'read_only' => true,
        'worksheet' => null,
        // 'strict'     => true,
        'headers' => null, // null, [], number, merge, increment
        'header_row' => 0, // false, 0, 1, 2...
    ];

    public function load()
    {
        $headers = $this->getOption('headers');
        $headerRow = $this->getOption('header_row');

        $reader = new ExcelReader(
            $this->getFile(),
            $headerRow,
            $this->getOption('worksheet'),
            $this->getOption('read_only')
            );

        if (false !== $headerRow) {
            // $duplicateHeaders = $headers == 'merge' ? ExcelReader::DUPLICATE_HEADERS_MERGE : CsvReader::DUPLICATE_HEADERS_INCREMENT;
            $reader->setHeaderRowNumber($headerRow);//, $duplicateHeaders);
        }

        if (is_array($headers)) {
            $reader->setColumnHeaders($headers);
        } elseif ('number' == $headers) {
            $headers = [];

            for ($i = 1; $i <= count($reader->getColumnHeaders()); ++$i) {
                $headers[] = 'field'.$i;
            }

            $reader->setColumnHeaders($headers);
        }

        // $reader->setStrict($this->getOption('strict'));

        return $this->setReader($reader);
    }
}
