<?php

/**
 * Cerbero custom settings
 * Created by Alby Hernández <me@achetronic.com>.
 */

return [

    'session' => [

        # Minutes that the sessions lives (then die)
        'lifetime' => env('CERBERO_SESSION_LIFETIME', 60)

        # 
    ]

];
