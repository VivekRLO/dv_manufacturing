<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Zone
 * @package App\Models
 * @version March 15, 2022, 2:43 pm +0545
 *
 * @property string $zone
 */
class Zone extends Model
{


    public $table = 'zones';
    



    public $fillable = [
        'zone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'zone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
