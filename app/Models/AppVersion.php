<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class AppVersion
 * @package App\Models
 * @version April 22, 2021, 4:20 pm +0545
 *
 * @property string $version
 * @property string $link
 * @property string $remarks
 */
class AppVersion extends Model
{


    public $table = 'app_versions';
    



    public $fillable = [
        'version',
        'link',
        'remarks'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'version' => 'string',
        'link' => 'string',
        'remarks' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
