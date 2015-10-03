<?php

namespace Adapta\Exceptions;

use RuntimeException;

class LoaderNotExistException extends RuntimeException
{
    public function __construct($loader)
    {
        parent::__construct("Loader [$loader] does not exist.");
    }
}
