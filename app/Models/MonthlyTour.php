<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class MonthlyTour
 * @package App\Models
 * @version September 5, 2021, 3:17 pm +0545
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property string $data
 */
class MonthlyTour extends Model
{


    public $table = 'monthly_tours';
    



    public $fillable = [
        'user_id',
        'data',
        'month',
        'year',
        'devicetime'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'month' => 'string',
        'year' => 'string',
        'devicetime'=>'string'
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
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
