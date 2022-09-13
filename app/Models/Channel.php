<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Channel
 * @package App\Models
 * @version March 15, 2022, 2:41 pm +0545
 *
 * @property string $channel
 */
class Channel extends Model
{


    public $table = 'channels';
    



    public $fillable = [
        'channel'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'channel' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
