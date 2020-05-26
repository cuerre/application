<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
     * @return Bool
     */
    public function SumCredits ( float $num )
    {
        return ($this->increment('credits', $num) == 1 ? true : false);
    }



    /**
     * Substract some credits to the user
     *
     * @return Bool
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
     * @return Bool
     */
    public function HasCredits ( )
    {
        # Never substract more than the current value
        if ( $this->credits > 0 ) {
            return true;
        }
        return false;
    }


}
