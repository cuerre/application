<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CuerreException extends Exception
{
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Flare, Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report( Throwable $exception )
    {
        parent::report($exception);
    }
}
