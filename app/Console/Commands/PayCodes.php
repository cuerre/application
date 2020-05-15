<?php

namespace App\Console\Commands;

use App\Code;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
//use Illuminate\Support\Facades\DB;

class PayCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay:codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Substract credits to users for using codes';

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

        $this->grace = 8; // hours
        $this->price = config('products.codes.price');
        $this->chunk = config('products.codes.chunk');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        # Take all users by chunks
        User::where('credits', '>', 0)
            ->orderBy('id')
            ->chunk($this->chunk, function ($users) {
                foreach ( $users as $user ) {

                    # Calculate min hour to avoid 
                    # the bill when deactivated
                    $grace = Carbon::now()
                                   ->subHours($this->grace)
                                   ->toTimeString();

                    # Get active and recently deactivated (12h)
                    $numCodes = Code::where('user_id', $user->id)
                                    ->where('active', true)
                                    ->orWhere(function($query) use ($grace) {
                                        $query->where('active', false)
                                              ->whereTime('updated_at', '>', $grace);
                                    })
                                    ->count();

                    # Substract the credits
                    $user->SubCredits( $this->price * $numCodes );
                }
            });
    }
}
