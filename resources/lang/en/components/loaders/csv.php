<?php

return [
    'name'    => 'CSV (Comma-Separated Values)',
    'help'    => '',
    'options' => [
        'delimiter' => [
            'name'    => 'Delimiter',
            'help'    => '',
            ],
        'enclosure' => [
            'name'    => 'Enclosure',
            'help'    => '',
            ],
        'escape' => [
            'name'    => 'Escape Character',
            'help'    => '',
            ],
        'strict' => [
            'name'    => 'Strict Number of Columns',
            'help'    => '',
            ],
        'headers' => [
            'name'    => 'Header Handling',
            'help'    => '',
            'options' => [
                'row' => [
                    'name'   => 'Row',
                    'help'   => 'Use headers in a row of the file',
                    ],
                'replace' => [
                    'name'   => 'Replace',
                    'help'   => 'Replace headers with defined headers',
                    ],
                'number' => [
                    'name'   => 'Numbered',
                    'help'   => 'Use field1, field2 etc. as headers',
                    ],
                'merge' => [
                    'name'   => 'Merge Duplicates',
                    'help'   => 'If duplicate headers exist, combine values into an array',
                    ],
                'increment' => [
                    'name'   => 'Increment Duplicates',
                    'help'   => 'If duplicate headers exist, increment the headers',
                    ],
                ],
            ],
        'header_row' => [
            'name'    => 'Header Row Number',
            'help'    => '',
            ],
        ],
];
