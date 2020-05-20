<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class Token extends Model
{      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'token', 
        'active', 
        'abilities', 
        'rate_limit'
    ];
    
    
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'abilities' => 'array',
    ];



    /**
     * Check an ability
     *
     * @return Bool
     */
    public function Can ( string $ability )
    {
        if( is_null($this) ){
            return false;
        }
        return Arr::has($this->abilities, $ability);
    }



    /**
     * Set 'active' state to false
     *
     * @return Bool
     */
    public function Unable ()
    {
        $this->active = false;
        if( !$this->save() ){
            return false;
        }
        return true;
    }



    /**
     * Set 'active' state to true
     *
     * @return Bool
     */
    public function Enable ()
    {
        $this->active = true;
        if( !$this->save() ){
            return false;
        }
        return true;
    }



    /**
     * Set an ability
     *
     * @return Bool
     */



    /**
     * Remove an ability
     *
     * @return Bool
     */



    /**
     * Set new rate limit
     *
     * @return Bool
     */



    /**
     * Check if a token
     * exists
     *
     * @return Bool
     */
    public static function Exists ( string $token )
    {
        $token = self::where('token', $token)->first();

        if ( is_null($token) )
            return false;

        return true;
    }
}
