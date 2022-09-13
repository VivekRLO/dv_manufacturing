<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletDeleteList extends Model
{
    use HasFactory;

    public $table = 'outlet_delete_lists';

    public $fillable = [
        'user_id',
        'outlet_id',
        'remark',
        'flag',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'outlet_id' => 'integer',
        'remark' => 'string',
        'flag' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function outlet()
    {
        return $this->belongsTo(\App\Models\Outlet::class, 'outlet_id', 'id');
    }

}
