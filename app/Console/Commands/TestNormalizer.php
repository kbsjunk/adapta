<?php

namespace Adapta\Console\Commands;

use Illuminate\Console\Command;
use Adapta\Components\Loaders\LoaderFactory;

use Ddeboer\DataImport\Writer\CsvWriter;

class TestNormalizer extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:normalizer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test normalizer.';

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

        $loader = LoaderFactory::make('csv');

        $loader->setFile('test/names.csv');

        $loader->load();

        $data = $loader->getData();

        $normalized = [];

        foreach ($data as $key => $row) {

            $normalized[$row['country']]['country'] = $row['country'];
            $normalized[$row['country']]['cities'][$row['city']]['city'] = $row['city'];
            $normalized[$row['country']]['cities'][$row['city']]['people'][$key] = array_only($row, ['first', 'last']);

        }

        $countries = [];
        $cities = [];
        $people = [];

        $idCountry = 1;
        $idCity = 1;
        $idPerson = 1;
        
        foreach ($normalized as $keyCountry => $valueCountry) {
            $countries[] = [
            'id'      => $keyCountry+1,
            'country' => $valueCountry['country']
            ];

            foreach ($valueCountry['cities'] as $keyCity => $valueCity) {
                $cities[] = [
                'id'      => $idCity,
                'city'    => $valueCity['city'],
                'country' => $idCountry,
                ];

                foreach ($valueCity['people'] as $keyPerson => $valuePerson) {
                    $people[] = [
                    'id'    => $idPerson,
                    'first' => $valuePerson['first'],
                    'last'  => $valuePerson['last'],
                    'city'  => $idCity,
                    ];

                    $idPerson++;
                }

                $idCity++;
            }

            $idCountry++;

        }

        $writer = new CsvWriter(',');
        $writer->setStream(fopen(storage_path('test/norm_countries.csv'), 'w'));

        $writer->writeItem(array('id', 'country'));
        foreach ($countries as $key => $value) {
            $writer->writeItem($value);
        }
        
        $writer->finish();

        $writer = new CsvWriter(',');
        $writer->setStream(fopen(storage_path('test/norm_cities.csv'), 'w'));

        $writer->writeItem(array('id', 'city', 'country'));
        foreach ($cities as $key => $value) {
            $writer->writeItem($value);
        }
        
        $writer->finish();

        $writer = new CsvWriter(',');
        $writer->setStream(fopen(storage_path('test/norm_people.csv'), 'w'));

        $writer->writeItem(array('id', 'first', 'last', 'city'));
        foreach ($people as $key => $value) {
            $writer->writeItem($value);
        }
        
        $writer->finish();

        dd($normalized);
        
    }
}
