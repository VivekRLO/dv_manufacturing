<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    public $table = 'quotations';

    public $fillable = [
        'user_id',
        'value',
        'month',
        'achieved',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'value' => 'string',
        'month' => 'string',
        'achieved' => 'string',
    ];

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

}
