<?php

return [
    'options' => [
        'delimiter' => [
            'default' => ',',
            'format'  => 'string',
            ],
        'enclosure' => [
            'default' => '"',
            'format'  => 'string',
            ],
        'escape' => [
            'default' => '\\',
            'format'  => 'string',
            ],
        'strict' => [
            'default' => true,
            'format'  => 'boolean',
            ],
        'headers' => [
            'default' => null,
            'format'  => 'various',
            'options' => [
                'row' => [
                    'format' => null,
                    ],
                'replace' => [
                    'format' => 'array',
                    ],
                'number' => [
                    'format' => 'string',
                    ],
                'merge' => [
                    'format' => 'string',
                    ],
                'increment' => [
                    'format' => 'string',
                    ],
                ],
            ],
        'header_row' => [
            'default' => 0,
            ],
        ],
];
