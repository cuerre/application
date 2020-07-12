<?php

namespace App;

use App\Exceptions\CodeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Code model
 * 
 * Methods:
 * $this->enable() : bool
 * $this->unable() : bool
 * 
 */
class Code extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'name', 
        'data', 
        'data->targets',
    ];
    
    
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];



    /**
     * The allowed targets 
     * to send traffic to
     * 
     * @var const array
     */
    const ALLOWED_TARGETS = [
        'any',
        'ios',
        'android',
        'win10'
    ];



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

        }catch( CodeException $e ){
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

        }catch( CodeException $e ){
            Log::error($e);
            return false;
        }
    }
}
