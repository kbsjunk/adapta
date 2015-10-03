<?php

namespace Adapta\Exceptions;

use RuntimeException;

class FileNotParseableException extends RuntimeException
{
    public function __construct($file, $format = null, $errors = null)
    {
        parent::__construct("The contents of the file \"$file\" are not in a valid $format format and cannot be understood.\n$errors");
    }
}
