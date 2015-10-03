<?php

namespace Adapta\Exceptions;

use RuntimeException;

class FileNotFoundException extends RuntimeException
{
    public function __construct($file)
    {
        parent::__construct("The file \"$file\" does not exist.");
    }
}
