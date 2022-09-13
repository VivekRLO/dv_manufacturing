<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteLog extends Model
{
    use HasFactory;
    protected $table = 'routelogs';
    protected $guarded = [];

    
    
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
    
    public function dse()
    {
        return $this->belongsTo(\App\Models\User::class, 'salesofficer_id', 'id');
    }

    public function routename()
    {
        return $this->belongsTo(\App\Models\RouteName::class, 'route', 'id');
    }
}
