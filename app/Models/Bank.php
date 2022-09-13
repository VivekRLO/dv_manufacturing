<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Bank
 * @package App\Models
 * @version May 27, 2021, 11:57 am +0545
 *
 * @property string $bank_name
 * @property string $bank_code
 */
class Bank extends Model
{


    public $table = 'banks';
    



    public $fillable = [
        'bank_name',
        'bank_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'bank_name' => 'string',
        'bank_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
