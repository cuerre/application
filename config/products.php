<?php

/**
 * Products Settings
 * Created by Alby Hernández <me@achetronic.com>.
 */

return [

    # Information of each product
    'codes' => [

        'price' => env('PRICE_CODES', 1),   // daily price
        'chunk' => env('CHUNK_CODES', 100), // users processed at the same time

    ]

];
