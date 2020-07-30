<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Exceptions\ModelException;

class User extends Authenticatable
{
    use Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    /**
     * Add some credits to the user
     *
     * @return bool
     */
    public function SumCredits ( float $num )
    {
        return ($this->increment('credits', $num) == 1 ? true : false);
    }



    /**
     * Substract some credits to the user
     *
     * @return bool
     */
    public function SubCredits ( float $num )
    {
        # Never substract more than the current value
        if ( $num > $this->credits ) {
            $num = $this->credits;
        }
        
        return ($this->decrement('credits', $num) == 1 ? true : false);
    }



    /**
     * Check if the user has credits
     *
     * @return bool
     */
    public function HasCredits ()
    {
        # Never substract more than the current value
        if ( $this->credits > 0 ) {
            return true;
        }
        return false;
    }



    /**
     * Get only billable tokens
     * 
     * @return Illuminate\Support\Collection
     */
    public function BillableTokens()
    {
        try {
            # Save config constants for ease
            $tokensGracePeriod  = config('cuerre.products.tokens.grace'); // hours

            # Calculate min hour to avoid # the bill
            $tokensGraceTime = Carbon::now()->subHours($tokensGracePeriod);

            # Take tokens that has been active some hours
            $billableTokens = Token::where('user_id', $this->id)
                                   ->where('active', true)
                                   ->orWhere(function($query) use ($tokensGraceTime) {
                                       $query->where('active', false)
                                             ->whereTime('updated_at', '>', $tokensGraceTime);
                                   })
                                   ->orderBy('id')
                                   ->get();

            return $billableTokens;

        } catch ( ModelException $e ){
            Log::error($e);
            return collect([]);
        }
    }



    /**
     * Get only billable codes
     * 
     * @return Illuminate\Support\Collection
     */
    public function BillableCodes()
    {
        try {
            # Save config constants for ease
            $codesGracePeriod  = config('cuerre.products.codes.grace'); // hours

            # Calculate min hour to avoid # the bill
            $codesGraceTime = Carbon::now()->subHours($codesGracePeriod);

            # Take codes that has been active some hours
            $billableCodes = Code::where('user_id', $this->id)
                                 ->where('active', true)
                                 ->orWhere(function($query) use ($codesGraceTime) {
                                     $query->where('active', false)
                                           ->whereTime('updated_at', '>', $codesGraceTime);
                                 })
                                 ->orderBy('id')
                                 ->get();

            return $billableCodes;

        } catch ( ModelException $e ){
            Log::error($e);
            return collect([]);
        }
    }



    /**
     * Calculate the number of credits
     * the user will have to pay
     * 
     * @return int
     */
    public function CurrentBill ()
    {
        try{
            # Save config constants for ease
            $tokenPrice         = config('cuerre.products.tokens.price');
            $codePrice          = config('cuerre.products.codes.price');

            # Which products are billable?
            $billableTokens = $this->BillableTokens();
            $billableCodes  = $this->BillableCodes();

            $totalToPay  = $billableTokens->count() * $tokenPrice;
            $totalToPay += $billableCodes->count()  * $codePrice;

            if( !is_int($totalToPay) ){
                throw new ModelException('Trying to return no int value');
            }
            return $totalToPay;

        } catch ( ModelException $e ) {
            Log::error($e);
            return 0;
        }

    }


}
