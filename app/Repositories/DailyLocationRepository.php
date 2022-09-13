<?php

namespace App\Repositories;

use App\Models\DailyLocation;
use App\Repositories\BaseRepository;

/**
 * Class DailyLocationRepository
 * @package App\Repositories
 * @version August 26, 2021, 3:32 pm +0545
*/

class DailyLocationRepository extends BaseRepository
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
        return DailyLocation::class;
    }
}
