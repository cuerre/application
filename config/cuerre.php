<?php

/**
 * Cuerre Settings
 * Created by Alby Hernández <me@achetronic.com>.
 */

return [

    # General vars 
    'version' => env('CUERRE_CURRENT_VERSION', '1.0'),
    'processing' => [
        'chunk' => env('CUERRE_PROCESSING_CHUNK', 100), // users processed at the same time on task scheduling
    ],

    #
    'billing' => [
        'currency' => env('CUERRE_BILLING_CURRENCY', 'eur'),
    ],

    # Information of each product
    'products' => [
        'codes' => [
            'prices' => [ 
                'small'  => env('CUERRE_PRODUCTS_CODES_PRICE_SMALL', 0.2),   // daily price
                'medium' => env('CUERRE_PRODUCTS_CODES_PRICE_MEDIUM', 0.15), // daily price
                'large'  => env('CUERRE_PRODUCTS_CODES_PRICE_LARGE', 0.1),   // daily price
            ],
            'grace' => env('CUERRE_PRODUCTS_CODES_GRACE', 12),
        ],
    ]

];
