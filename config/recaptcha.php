<?php

/**
 * Recaptcha custom settings
 * Created by Alby Hernández <me@achetronic.com>.
 */

return [
    'public' => env('RECAPTCHA_PUBLIC', 'Your public key'),
    'secret' => env('RECAPTCHA_SECRET', 'Your private key') ,
];
