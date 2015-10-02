<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Adapta\Components\Loaders\CsvLoader;

class CsvLoaderTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testMakeLoader()
    {
        $loader = new CsvLoader;
		
		
    }
}
