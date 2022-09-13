<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Order
 * @package App\Models
 * @version September 3, 2021, 3:10 pm +0545
 *
 * @property \App\Models\DIstributor $id
 * @property integer $order_id
 * @property integer $distributor_id
 * @property string $status
 */
class Order extends Model
{


    public $table = 'orders';
    



    public $fillable = [
        'order_id',
        'distributor_id',
        'status',
        'quantity'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'distributor_id' => 'integer',
        'status' => 'string',
        'quantity' => 'string',
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
        return $this->belongsTo(\App\Models\Distributor::class);
    }
}
