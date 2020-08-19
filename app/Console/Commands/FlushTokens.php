<?php

namespace App\Console\Commands;

use Exception;
use App\Token;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;

class FlushTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flush:tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all tokens from cache';

    /**
     * The number of users processed 
     * at the same time
     *
     * @var int
     */
    protected $chunk;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->chunk = config('cuerre.processing.chunk');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            # Take all tokens by chunks
            Token::orderBy('id')->chunk($this->chunk, function ($tokens) {

                # Delete tokens from cache step by step
                foreach ( $tokens as $token ) {
                    Redis::del($token->token);
                }
            });

        } catch ( Exception $e ) {
            Log::error( $e );
        }
    }
}
