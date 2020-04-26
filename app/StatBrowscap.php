<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatBrowscap extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stats_browscap';
    
    
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_id', 'data'
    ];
    
    
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];
}
