<?php

namespace App;

use App\Exceptions\TokenException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Token model
 * 
 * Methods:
 * $this->can($ability) : bool
 * $this->setAbility($ability) : bool
 * $this->removeAbility($ability) : bool
 * $this->enable() : bool
 * $this->unable() : bool
 * $this->setLimit($limit) : bool
 * self::exists($token) : bool
 * 
 */
class Token extends Model
{      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
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
     * @param string $ability
     * @return bool
     */
    public function can ( string $ability = null )
    {
        try{

            if( is_null($this) ){
                return false;
            }

            $abilities = collect($this->abilities);
            $result = $abilities->values()->search($ability);

            if( $result === false ){
                return false;
            }

            return true;

        }catch( TokenException $e ){
            Log::error($e);
            return false;
        }
    }



    /**
     * Set an ability
     * into a token
     *
     * @param string $ability
     * @return bool
     */
    public function setAbility ( string $ability ) : bool
    {
        try{

            if( is_null($this) ){
                return false;
            }

            if( $this->can($ability) ){
                return true;
            }

            $abilities = collect($this->abilities);
            $abilities->push($ability);

            $this->abilities = $abilities->toArray();

            if( !$this->save() ){
                return false;
            }
            return true;

        }catch( TokenException $e ){
            Log::error($e);
            return false;
        }
    }



    /**
     * Remove an ability
     *
     * @param string $ability
     * @return bool
     */
    public function removeAbility ( string $ability ) : bool
    {
        try{

            if( is_null($this) ){
                return false;
            }

            if( $this->can($ability) ){
                return true;
            }

            $abilities = collect($this->abilities);
            $abilities = $abilities->filter(function ($value, $key) use($ability){
                return $value != $ability;
            })->values();
            
            $this->abilities = $abilities->toArray();

            if( !$this->save() ){
                return false;
            }
            return true;

        }catch( TokenException $e ){
            Log::error($e);
            return false;
        }
    }



    /**
     * Set 'active' state to false
     *
     * @return bool
     */
    public function unable ()
    {
        try{
            if( is_null($this) ){
                return false;
            }

            $this->active = false;
            if( !$this->save() ){
                return false;
            }
            return true;

        }catch( TokenException $e ){
            Log::error($e);
            return false;
        }
    }



    /**
     * Set 'active' state to true
     *
     * @return bool
     */
    public function enable ()
    {
        try{
            if( is_null($this) ){
                return false;
            }

            $this->active = true;
            if( !$this->save() ){
                return false;
            }
            return true;

        }catch( TokenException $e ){
            Log::error($e);
            return false;
        }
    }



    /**
     * Set new rate limit
     *
     * @param int $limit
     * @return bool
     */
    public function setLimit ( int $limit ) : bool
    {
        try{
            if( is_null($this) ){
                return false;
            }

            $this->rate_limit = abs($limit);
            if( !$this->save() ){
                return false;
            }
            return true;

        }catch( TokenException $e ){
            Log::error($e);
            return false;
        }
    }
    


    /**
     * Check if a token
     * exists
     *
     * @param string $token
     * @return bool
     */
    public static function exists ( string $token )
    {
        try{
            $token = self::where('token', $token)->first();

            if ( is_null($token) )
                return false;

            return true;
        }catch( TokenException $e ){
            Log::error($e);
            return false;
        }
        
    }
}
