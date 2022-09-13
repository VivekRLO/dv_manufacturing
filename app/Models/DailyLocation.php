<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class DailyLocation
 * @package App\Models
 * @version August 26, 2021, 3:32 pm +0545
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property string $longitude
 * @property string $latitude
 * @property string $date
 */
class DailyLocation extends Model
{


    public $table = 'daily_locations';
    



    public $fillable = [
        'user_id',
        'longitude',
        'latitude',
        'date',
        'checkinout_id',
        'outlet_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'longitude' => 'double',
        'latitude' => 'double',
        'date' => 'datetime',
        'checkinout' =>'integer',
        'outlet_id' =>'integer'

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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
