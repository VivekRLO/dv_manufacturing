<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Distributor
 * @package App\Models
 * @version April 7, 2021, 10:11 am UTC
 *
 * @property string $name
 * @property string $email
 * @property string $contact
 * @property string $location
 * @property string $owner_name
 * @property string $pan_no
 * @property number $latitude
 * @property number $longitude
 */
class Distributor extends Model
{


    public $table = 'distributors';




    public $fillable = [
        'name',
        'owner_name',
        'pan_no',
        'email',
        'sales_officer_id',
        'regionalmanager',
        'sales_supervisor_id',
        'contact',
        'location',
        'latitude',
        'longitude',
        'flag',
        'manufacturer_trading_type',
        'userid',
        'zone_id',
        'town_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'userid' => 'integer',
        'sales_officer_id' => 'integer',
        'regionalmanager'=>'integer',
        'sales_supervisor_id'=>'integer',
        'name' => 'string',
        'owner_name' => 'string',
        'pan_no' => 'string',
        'email' => 'string',
        'contact' => 'string',
        'location' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'manufacturer_trading_type'=>'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'sales_officer', 'id');
    }
    public function rm()
    {
        return $this->belongsTo(\App\Models\User::class, 'regionalmanager', 'id');
    }
    public function ss()
    {
        return $this->belongsTo(\App\Models\User::class, 'sales_supervisor_id', 'id');
    }
    public function distributor_salesOfficer(){
        return $this->belongsToMany(\App\Models\User::class);
    }
   public function zones(){
    return $this->belongsTo(\App\Models\Zone::class, 'zone_id', 'id');
   }
   public function towns(){
    return $this->belongsTo(\App\Models\Town::class, 'town_id', 'id');
   }
}
