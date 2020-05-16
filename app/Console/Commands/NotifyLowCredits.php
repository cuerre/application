<?php

namespace App\Console\Commands;

use App\Code;
use App\User;
use Illuminate\Console\Command;
use App\Http\Controllers\NotificationController;

class NotifyLowCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:lowcredits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users with low credits';

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

        $this->chunk = config('products.chunk');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        # Take all users by chunks
        User::orderBy('id')
            ->chunk($this->chunk, function ($users) {
                foreach ($users as $user) {

                    # Check if the user has created codes
                    $numCodes = Code::where('user_id', $user->id)->count();
                    $sumCodes = $numCodes * config('products.codes.price');

                    # Check if the user has created tokens
                    $numTokens = $user->tokens()->count();
                    $sumTokens = $numTokens * config('products.tokens.price');

                    # Total credits needed
                    $neededCredits = $sumCodes + $sumTokens;

                    # Has created codes? 
                    if ( $user->credits <  $neededCredits ){

                        # Notify to buy more
                        $notification = new NotificationController( $user );
                        $notification->NotifyLowCredits();
                    }
                }
            });
    }
}
