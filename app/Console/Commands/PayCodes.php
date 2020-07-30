<?php

namespace App\Console\Commands;

use Exception;
use App\Code;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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

        $this->chunk = config('cuerre.processing.chunk');
        $this->price = config('cuerre.products.codes.price');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            # Take all users by chunks
            User::orderBy('id')
            ->chunk($this->chunk, function ($users) {
                foreach ( $users as $user ) {

                    $codes = $user->BillableCodes();

                    # Pay for the code or unable it
                    $codes->each(function($code) use ($user) {
                        if( $user->credits > 0 ){
                            $user->SubCredits( $this->price );
                        }else{
                            $code->Unable();
                        }
                    });
                }
            });

        } catch ( Exception $e ){
            Log::error( $e );
        }
        
    }
}
