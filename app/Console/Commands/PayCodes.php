<?php

namespace App\Console\Commands;

use App\Code;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
                foreach ($users as $user) {

                    # Check if the user has created codes
                    $hasCodes = Code::where('user_id', $user->id)->exists();

                    # Has created codes? substract credits
                    if ( $hasCodes ){
                        $user->credits -= $this->price;
                        $user->save();
                    }
                }
            });
    }
}
