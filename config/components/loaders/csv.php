<?php

return [
    'name' => 'CSV (Comma-Separated Values)',
    'help' => 
    'options' => [
        'delimiter' => [
			'name'    => 'Delimiter',
			'default' => ',',
			'format'  => 'string',
            ],
        'enclosure' => [
			'name'    => 'Enclosure',
			'default' => '"',
			'format'  => 'string',
            ],
        'escape' => [
			'name'    => 'Escape Character',
			'default' => '\\',
			'format'  => 'string',
            ],
        'strict' => [
			'name'    => 'Strict Number of Columns',
			'default' => true,
			'format'  => 'boolean',
            ],
        'headers' => [
			'name'    => 'Header Handling',
			'default' => null,
			'format'  => 'various',
            'options' => [
                'row' => [
					'name'   => 'Use headers in a row of the file',
					'format' => null,
                    ],
                'replace' => [
					'name'   => 'Replace headers with defined headers',
					'format' => 'array',
                    ],
                'number' => [
					'name'   => 'Use field1, field2 etc. as headers',
					'format' => 'string',
                    ],
                'merge' => [
					'name'   => 'If duplicate headers exist, combine values into an array',
					'format' => 'string',
                    ],
                'increment' => [
					'name'   => 'If duplicate headers exist, increment the headers',
					'format' => 'string',
                    ],
                ],
            ],
        'header_row' => [
			'name'    => 'Header Row',
			'default' => 0,
            ],
        ],
];
