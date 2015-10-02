<?php

namespace Adapta\Exceptions;

use RuntimeException;

class FileNotFoundException extends RuntimeException {
	
	public function __construct($file)
	{
		parent::__construct("File [$file] does not exist.");
	}
	
}