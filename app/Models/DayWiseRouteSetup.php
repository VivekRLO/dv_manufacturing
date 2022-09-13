<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayWiseRouteSetup extends Model
{
    use HasFactory;

    public $table = 'day_wise_route_setups';

    public $fillable = [
        'user_id',
        'route_id',
        'day',
        'date',
        'checkinout_id',
        'outlet_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'route_id' => 'integer',
        'day' => 'string',
    ];

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function routes()
    {
        return $this->belongsTo(\App\Models\RouteName::class, 'route_id', 'id');
    }

}
