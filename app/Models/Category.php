<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Category
 * @package App\Models
 * @version March 15, 2022, 2:42 pm +0545
 *
 * @property string $category
 */
class Category extends Model
{


    public $table = 'categories';
    



    public $fillable = [
        'category'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
