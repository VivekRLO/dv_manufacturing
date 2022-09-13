<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\Address;



/**
 * Class Outlet
 * @package App\Models
 * @version April 7, 2021, 4:41 am UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Province $province
 * @property \App\Models\District $district
 * @property \App\Models\Area $area
 * @property \App\Models\Street $street
 * @property string $name
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $area_id
 * @property integer $street_id
 * @property string $contact
 * @property string $type
 * @property number $latitude
 * @property number $longitude
 * @property integer $sales_officer_id
 */
class Outlet extends Model
{


    public $table = 'outlets';

    public $fillable = [
        'name',
        'owner_name',
        'contact',
        // 'type',
        'latitude',
        'longitude',
        'sales_officer_id',
        'address_id',
        'street',
        'distributor_id',
        'image',
        'flag',
        'zone',
        'town_id',
        'route_id',
        'channel_id',
        'category_id',
        'dse',
        'so',
        'manager',
        'visit_frequency',
        'outlet_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'outlet_id' => 'integer',
        'name' => 'string',
        'owner_name' => 'string',
        'address_id' => 'integer',
        'street' => 'string',
        'contact' => 'string',
        // 'type' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
        'sales_officer_id' => 'integer',
        'distributor_id'=>'integer',
        'image'=>'string',
        'zone'=> 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'sales_officer_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function address()
    {
        return $this->belongsTo(\App\Models\Address::class, 'address_id', 'id');
    }

    public function distributor()
    {
        return $this->belongsTo(\App\Models\Distributor::class, 'distributor_id', 'id');
    }
    public function towns()
    {
        return $this->belongsTo(\App\Models\Town::class, 'town_id', 'id');
    }
    public function zones()
    {
        return $this->belongsTo(\App\Models\Zone::class, 'zone_id', 'id');
    }
    public function routenames()
    {
        return $this->belongsTo(\App\Models\RouteName::class, 'route_id', 'id');
    }
    public function categories()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }
    public function channels()
    {
        return $this->belongsTo(\App\Models\Channel::class, 'channel_id', 'id');
    }
    public function sales()
    {
        return $this->hasMany(\App\Models\Sale::class, 'outlet_id');
    }
}
