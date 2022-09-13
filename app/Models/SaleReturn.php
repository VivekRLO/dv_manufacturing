<?php

namespace App\Models;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;



/**
 * Class SaleReturn
 * @package App\Models
 * @version February 1, 2022, 11:16 am +0545
 *
 * @property \App\Models\Distributor $distributor
 * @property \App\Models\Batch $batch
 * @property \App\Models\Product $product
 * @property integer $distributor_id
 * @property integer $batch_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $returndate
 * @property string $remarks
 */
class SaleReturn extends Model
{


    public $table = 'sale_returns';
    



    public $fillable = [
        'distributor_id',
        'batch_id',
        'product_id',
        'quantity',
        'returndate',
        'remarks'
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
        'quantity' => 'integer',
        'returndate' => 'datetime',
        'remarks' => 'string'
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
    public function batch()
    {
        return $this->belongsTo(\App\Models\Batch::class, 'batch_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }
}
