<?php

namespace Adapta\Components\Loaders;

use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Ddeboer\DataImport\Reader\ArrayReader;
use Adapta\Exceptions\FileNotParseableException;

class JsonLoader extends AbstractFileLoader implements LoaderInterface
{
    protected $options = [
        'allow_duplicate_keys' => true,
    ];

    public function load()
    {
        $parser = new JsonParser();

        $contents = $this->file->fread($this->file->getSize());

        try {
            $options = JsonParser::PARSE_TO_ASSOC;

            if ($this->getOption('allow_duplicate_keys')) {
                $options = $options | JsonParser::ALLOW_DUPLICATE_KEYS;
            }

            $contents = $parser->parse($contents, $options);
        } catch (ParsingException $e) {
            throw new FileNotParseableException($this->filename, 'JSON', $e->getMessage());
        }

        if (is_array($contents)) {
            $reader = new ArrayReader($contents);

            return $this->setReader($reader);
        }

        throw new FileNotParseableException($this->filename, 'JSON', 'The file is not an array.');
    }
}
