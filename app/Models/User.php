<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    protected $table = 'useres'; 

    public $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'type',
        'regionalmanager',
        'sales_supervisor_id',
        'flag',
        'last_login_at',
        'last_login_ip_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
    public function distributors()
    {
        return $this->hasMany(Distributor::class, 'sales_officers');
    }
    public function so_distributors()
    {
        return $this->hasMany(Distributor::class, 'sales_supervisor_id');
    }
    public function rm_distributors()
    {
        return $this->hasMany(Distributor::class, 'regionalmanager');
    }
    public function salesOfficer_distributor(){
        return $this->belongsToMany(\App\Models\Distributor::class);
    }
    public function route_users()
    {
        return $this->belongsToMany(\App\Models\RouteName::class,'routename_user','user_id','route_id');
    }
   
}
