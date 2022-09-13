<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class CheckInOut
 * @package App\Models
 * @version April 13, 2021, 2:50 pm +0545
 *
 * @property \App\Models\User $salesOfficer
 * @property integer $sales_officer_id
 * @property string $check_type
 * @property number $latitude
 * @property number $longitude
 */
class CheckInOut extends Model
{


    public $table = 'check_in_outs';
    



    public $fillable = [
        'sales_officer_id',
        'checkin_latitude',
        'checkin_longitude',
        'checkin_device_time',
        'checkout_latitude',
        'checkout_longitude',
        'checkout_device_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sales_officer_id' => 'integer',
        'checkin_latitude' => 'double',
        'checkin_longitude' => 'double',
        'updated_at'=>'datetime:Y-m-d H:m:s',
        'created_at'=>'datetime:Y-m-d H:m:s',
        'checkin_device_time'=>'string',
        'checkout_latitude' => 'double',
        'checkout_longitude' => 'double',
        'checkout_device_time'=>'string'
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
    public function salesOfficer()
    {
        return $this->belongsTo(\App\Models\User::class, 'sales_officer_id', 'id');
    }
    public function location()
    {
        return $this->hasOne(\App\Models\DailyLocation::class, 'checkinout_id', 'id')->orderBy('date', 'desc');
    }
}

