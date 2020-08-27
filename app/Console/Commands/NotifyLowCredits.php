<?php

namespace App\Console\Commands;

use Exception;
use App\Code;
use App\User;
use Illuminate\Support\Facades\Log;
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
            # Take all users by chunks
            User::orderBy('id')
            ->chunk($this->chunk, function ($users) {
                foreach ($users as $user) {

                    # Check created codes
                    $codes = $user->BillableCodes()->count();
                    $price = $user->CurrentCodePrice ();

                    # Total credits needed
                    $neededCredits = $codes + $price;

                    # Has created codes? 
                    if ( $user->credits <  $neededCredits ){

                        # Notify to buy more
                        $notification = new NotificationController( $user );
                        $notification->NotifyLowCredits();
                    }
                }
            });
        }catch( Exception $e ){
            Log::error($e);
        }
        
    }
}
