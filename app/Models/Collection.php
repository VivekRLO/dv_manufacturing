<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Collection
 * @package App\Models
 * @version April 11, 2021, 2:37 pm +0545
 *
 * @property \App\Models\Distributor $distributor
 * @property \App\Models\User $saleOfficer
 * @property integer $distributor_id
 * @property string $mode
 * @property string $bank_name
 * @property string $cheque_no
 * @property number $amount
 * @property integer $sales_officer_id
 * @property string $account_of
 * @property string $remarks
 */
class Collection extends Model
{

    public $increments='false';
    public $table = 'collections';
    



    public $fillable = [
        'id',
        'distributor_id',
        'mode',
        'bank_name',
        'cheque_no',
        'cheque_photo',
        'amount',
        'sales_officer_id',
        'account_of',
        'remarks',
        'device_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'distributor_id' => 'integer',
        'mode' => 'string',
        'bank_name' => 'string',
        'cheque_no' => 'string',
        'cheque_photo' => 'string',
        'amount' => 'integer',
        'sales_officer_id' => 'integer',
        'account_of' => 'string',
        'remarks' => 'string',
        'device_time'=> 'string'
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
    public function salesOfficer()
    {
        return $this->belongsTo(\App\Models\User::class, 'sales_officer_id', 'id');
    }
}
