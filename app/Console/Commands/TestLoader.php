<?php

namespace Adapta\Console\Commands;

use Illuminate\Console\Command;
use Adapta\Components\Loaders\LoaderFactory;
use Adapta\Components\Converters\PersonalNameConverter;
use Config;

class TestLoader extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:loader {loader} {file} {key?}';

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

$converter = new PersonalNameConverter();
$string = $converter('Karl-Peter von Schmidt');

dd($string);


        $loader = LoaderFactory::make($this->argument('loader'));

        $loader->setFile($this->argument('file'));

        // $loader->setOption('delimiter', ';');
        // $loader->setOption('header_row', 1);
        // $loader->setOption('headers', 'number');
        // $loader->setOption('strict', false);

        $loader->load();

        $reader = $loader->getReader();

        // $reader = var_export($reader, 1);

        // \File::put(base_path('config/components/loaders/csv.php'), $reader);
        // $reader = json_encode($reader, JSON_PRETTY_PRINT);

        // dd($reader);

        // if ($key = $this->argument('key')) {
        //     $reader = array_get($reader, $key);
        // }

        // $data = [];

        // foreach ($reader as $row) {
        //     $data[] = $row;
        // }

        // $this->table(array_keys(head($data)), $data);

        // return;

        // foreach ($loader->getReader() as $key => $row)
        // {
        //     echo $key; var_dump($row);
        //     echo '-----';
        // }
        
        // dd($loader);
        
    }
}
