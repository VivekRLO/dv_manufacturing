<?php

namespace App\Repositories;

use App\Models\CheckInOut;
use App\Repositories\BaseRepository;

/**
 * Class CheckInOutRepository
 * @package App\Repositories
 * @version April 13, 2021, 2:50 pm +0545
*/

class CheckInOutRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CheckInOut::class;
    }
}
