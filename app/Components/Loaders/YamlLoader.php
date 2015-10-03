<?php

namespace Adapta\Components\Loaders;

use Ddeboer\DataImport\Reader\ArrayReader;
use Symfony\Component\Yaml\Parser;
use Adapta\Exceptions\FileNotParseableException;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlLoader extends AbstractFileLoader implements LoaderInterface
{
    protected $options = [
    ];

    public function load()
    {
        $contents = $this->file->fread($this->file->getSize());

        $yaml = new Parser();

        try {
            $contents = $yaml->parse($contents);

            if (is_array($contents)) {
                $reader = new ArrayReader($contents);

                return $this->setReader($reader);
            }
        } catch (ParseException $e) {
            throw new FileNotParseableException($this->filename, 'YAML', $e->getMessage());
        }

        throw new FileNotParseableException($this->filename, 'YAML');
    }
}
