<?php

namespace App\Console\Commands;

use Exception;
use App\Code;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
//use Illuminate\Support\Facades\DB;

class PayTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay:tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Substract credits to users for using tokens';

    /**
     * Grace period. You need at least 
     * 8 hours from deactivating code
     * not to pay that day
     *
     * @var int
     */
    protected $grace;

    /**
     * The price of the service in credits
     *
     * @var int
     */
    protected $price;

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
        $this->grace = config('cuerre.products.tokens.grace'); // hours
        $this->price = config('cuerre.products.tokens.price');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            # Take all users by chunks
            User::orderBy('id')
            ->chunk($this->chunk, function ($users) {
                foreach ( $users as $user ) {

                    # Calculate min hour to avoid 
                    # the bill
                    $grace = Carbon::now()
                                ->subHours($this->grace);

                    # Take all the tokens for this user
                    $tokens = $user->tokens()
                                ->whereNotNull('last_used_at')
                                ->orderBy('id')
                                ->get();

                    # Pay for the used tokens or unable it
                    $tokens->each(function($token) use ($user, $grace) {

                        $lastUsed = Carbon::parse($token->last_used_at);
                        $lastFree = $grace;

                        # Was used into grace period?
                        if( ! $lastUsed->isAfter($lastFree) ){
                            return;
                        }

                        # Used. Discount credits or delete
                        if( $user->credits > 0 ){
                            $user->SubCredits( $this->price );
                        }else{
                            $token->delete();
                        }
                    });
                }
            });

        } catch ( Exception $e ) {
            Log::error( $e );
        }
    }
}
