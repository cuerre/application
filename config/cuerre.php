<?php

/**
 * Cuerre Settings
 * Created by Alby Hernández <me@achetronic.com>.
 */

return [

    # General vars 
    'processing' => [
        'chunk' => env('CUERRE_PROCESSING_CHUNK', 100), // users processed at the same time
    ],

    # Information of each product
    'products' => [
        'codes' => [
            'price' => env('CUERRE_PRODUCTS_CODES_PRICE', 1),   // daily price
            'grace' => env('CUERRE_PRODUCTS_CODES_GRACE', 8),
        ],
        'tokens' => [
            'price' => env('CUERRE_PRODUCTS_TOKENS_PRICE', 1),   // daily price
            'grace' => env('CUERRE_PRODUCTS_TOKENS_GRACE', 12),
        ]
    ]

];
