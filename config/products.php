<?php

/**
 * Products Settings
 * Created by Alby Hernández <me@achetronic.com>.
 */

return [

    'chunk' => env('PRODUCTS_CHUNK', 100),

    # Information of each product
    'codes' => [
        'price' => env('PRODUCTS_CODES_PRICE', 1),   // daily price
        'chunk' => env('CHUNK_CODES', 100), // users processed at the same time
    ],
    'tokens' => [
        'price' => env('PRODUCTS_TOKENS_PRICE', 1),   // daily price
        'chunk' => env('CHUNK_TOKENS', 100), // users processed at the same time
    ]

];
