<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Town
 * @package App\Models
 * @version March 15, 2022, 2:44 pm +0545
 *
 * @property \App\Models\Zone $zone
 * @property string $town
 * @property integer $zone_id
 */
class Town extends Model
{


    public $table = 'towns';
    



    public $fillable = [
        'town',
        'zone_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'town' => 'string',
        'zone_id' => 'integer'
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
    public function zone()
    {
        return $this->belongsTo(\App\Models\Zone::class, 'zone_id', 'id');
    }
}
