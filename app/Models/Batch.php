<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Batch
 * @package App\Models
 * @version April 7, 2021, 10:24 am UTC
 *
 * @property \App\Models\Product $product
 * @property integer $product_id
 * @property string $expired_at
 * @property string $manufactured_at
 * @property integer $stock
 */
class Batch extends Model
{


    public $table = 'batches';
    



    public $fillable = [
        'product_id',
        'expired_at',
        'manufactured_at',
        'stock'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'expired_at' => 'datetime',
        'manufactured_at' => 'datetime',
        'stock' => 'integer'
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
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }
}
