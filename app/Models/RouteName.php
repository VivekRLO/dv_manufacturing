<?php

namespace App\Models;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;



/**
 * Class RouteName
 * @package App\Models
 * @version March 15, 2022, 3:04 pm +0545
 *
 * @property \App\Models\Distributor $distributor
 * @property string $routename
 * @property integer $distributor_id
 */
class RouteName extends Model
{


    public $table = 'route_names';
    



    public $fillable = [
        'routename',
        'distributor_id',
        'flag',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'routename' => 'string',
        'distributor_id' => 'integer',
        'flag' => 'boolean',
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
    public function distributor()
    {
        return $this->belongsTo(\App\Models\Distributor::class, 'distributor_id', 'id');
    }
  
    public function route_users(){
        return $this->belongsToMany(\App\Models\User::class,'routename_user','route_id','user_id');
    }

    public function outlets(){
        return $this->hasMany(\App\Models\Outlet::class, 'route_id');
    }

}
