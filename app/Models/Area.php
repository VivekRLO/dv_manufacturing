<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Area
 * @package App\Models
 * @version April 6, 2021, 9:52 am UTC
 *
 * @property \App\Models\District $district
 * @property \Illuminate\Database\Eloquent\Collection $streets
 * @property integer $district_id
 * @property string $name
 */
class Area extends Model
{

    public $timestamps = false;
    public $table = 'areas';
    



    public $fillable = [
        'district_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'district_id' => 'integer',
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
    public function district()
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function streets()
    {
        return $this->hasMany(\App\Models\Street::class, 'area_id', 'id');
    }
}
