<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Product
 * @package App\Models
 * @version April 7, 2021, 10:18 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $batches
 * @property string $name
 * @property string $unit
 * @property integer $value
 */
class Product extends Model
{


    public $table = 'products';


    public $fillable = [
        'name',
        'unit',
        'value',
        'flag',
        'catalog',
        'brand_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'unit' => 'string',
        'value' => 'integer',
        'catalog'=>'string',
        'brand_name'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function batches()
    {
        return $this->hasMany(\App\Models\Batch::class, 'product_id', 'id');
    }
    public function stockHistory(){
        
        return $this->hasOne(\App\Models\StockHistory::class, 'product_id', 'id')->latest()->select(array('product_id','batch_id','total_stock_remaining_in_distributor'));
    }
}
