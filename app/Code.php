<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'data', 'data->targets',
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
}
