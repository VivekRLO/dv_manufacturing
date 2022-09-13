<?php

namespace App\Models;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;



/**
 * Class Sale
 * @package App\Models
 * @version April 9, 2021, 4:47 pm +0545
 *
 * @property \App\Models\User $users
 * @property \App\Models\Distributor $distributor
 * @property \App\Models\Batch $baqtch
 * @property \App\Models\Product $product
 * @property integer $sales_officer_id
 * @property integer $distributor_id
 * @property integer $batch_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $sold_at
 */
class Sale extends Model
{


    public $table = 'sales';
    



    public $fillable = [
        'sales_officer_id',
        'distributor_id',
        'batch_id',
        'product_id',
        'quantity',
        'sold_at',
        'outlet_id',
        'discount',
        'sold_to',
        'scheme',
        'remarks',
        'route_id',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sales_officer_id' => 'integer',
        'distributor_id' => 'integer',
        'batch_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
        'sold_at' => 'string',
        'outlet_id' => 'integer',
        'latitude' => 'string',
        'longitude' => 'string',
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'sales_officer_id', 'id');
    }

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
        return $this->belongsTo(\App\Models\Batch::class, 'batch_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class,'product_id','id');
    }
    public function outlet()
    {
        return $this->belongsTo(\App\Models\Outlet::class,'outlet_id','id');
    }
}
