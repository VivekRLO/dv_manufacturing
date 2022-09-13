<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Street
 * @package App\Models
 * @version April 6, 2021, 9:54 am UTC
 *
 * @property \App\Models\Area $area
 * @property integer $area_id
 * @property string $name
 */
class Street extends Model
{

    public $timestamps = false;
    public $table = 'streets';
    



    public $fillable = [
        'area_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'area_id' => 'integer',
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
    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'area_id', 'id');
    }
}
