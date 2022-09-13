<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class StockHistory
 * @package App\Models
 * @version April 7, 2021, 11:22 am UTC
 *
 * @property \App\Models\Distributor $distributor
 * @property \App\Models\Product $product
 * @property \App\Models\Batch $batch
 * @property integer $distributor_id
 * @property integer $batch_id
 * @property integer $product_id
 * @property integer $price
 * @property integer $total_stock_remaining_in_distributor
 * @property integer $stock_in
 * @property integer $stock_out
 */
class StockHistory extends Model
{


    public $table = 'stock_histories';
    



    public $fillable = [
        'distributor_id',
        'batch_id',
        'product_id',
        'price',
        'total_stock_remaining_in_distributor',
        'stock_in',
        'stock_out'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'distributor_id' => 'integer',
        'batch_id' => 'integer',
        'product_id' => 'integer',
        'price' => 'integer',
        'total_stock_remaining_in_distributor' => 'integer',
        'stock_in' => 'integer',
        'stock_out' => 'integer'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function batch()
    {
        return $this->belongsTo(\App\Models\Batch::class, 'batch_id', 'id');
    }
}
