<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Province
 * @package App\Models
 * @version April 6, 2021, 9:45 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $districts
 * @property string $name
 */
class Province extends Model
{

    public $timestamps = false;
    public $table = 'provinces';
    



    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function districts()
    {
        return $this->hasMany(\App\Models\District::class, 'province_id', 'id');
    }
    public function location()
    {
        return $this->hasMany(\App\Models\District::class, 'province_id', 'id');
    }
}
