<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class StockCount
 * @package App\Models
 * @version September 6, 2021, 12:30 pm +0545
 *
 * @property \App\Models\User $saleOfficer
 * @property \App\Models\Distributor $distributor
 * @property string $stock
 * @property string $type
 * @property string $date
 * @property integer $sale_officer_id
 * @property integer $distributor_id
 */
class StockCount extends Model
{


    public $table = 'stock_counts';
    



    public $fillable = [
        'stock',
        'type',
        'date',
        'sale_officer_id',
        'distributor_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'date' => 'string',
        'sale_officer_id' => 'integer',
        'distributor_id' => 'integer'
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
    public function saleOfficer()
    {
        return $this->belongsTo(\App\Models\User::class, 'sale_officer_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function distributor()
    {
        return $this->belongsTo(\App\Models\Distributor::class, 'distributor_id', 'id');
    }
}
