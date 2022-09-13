<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class District
 * @package App\Models
 * @version April 6, 2021, 9:50 am UTC
 *
 * @property \App\Models\Province $province
 * @property \Illuminate\Database\Eloquent\Collection $areas
 * @property integer $province_id
 * @property string $name
 */
class District extends Model
{

    public $timestamps = false;
    public $table = 'districts';
    



    public $fillable = [
        'province_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'province_id' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function province()
    {
        return $this->belongsTo(\App\Models\Province::class, 'province_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function areas()
    {
        return $this->hasMany(\App\Models\Area::class, 'district_id', 'id');
    }
}
