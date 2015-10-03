<?php

namespace Adapta\Components\Loaders;

use SplFileObject;
use File;
use Adapta\Exceptions\FileNotFoundException;

abstract class AbstractFileLoader implements LoaderInterface
{
    protected $file;

    protected $filename;

    protected $reader;

    protected $options = [];

    public function setFile($filename)
    {
        $this->filename = $filename;

        $file = storage_path($filename);

        if (File::exists($file)) {
            $this->file = new SplFileObject($file);

            return true;
        }

        throw new FileNotFoundException($filename, 'JSON');
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
