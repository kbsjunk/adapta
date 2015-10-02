<?php

namespace Adapta\Console\Commands;

use Illuminate\Console\Command;
use Adapta\Components\Loaders\LoaderFactory;

class TestLoader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:loader {loader} {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test loader.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $loader = LoaderFactory::make($this->argument('loader'), $this->argument('file'));
        
        dd($loader);
        
    }
}
