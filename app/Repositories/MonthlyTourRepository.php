<?php

namespace App\Repositories;

use App\Models\MonthlyTour;
use App\Repositories\BaseRepository;

/**
 * Class MonthlyTourRepository
 * @package App\Repositories
 * @version September 5, 2021, 3:17 pm +0545
*/

class MonthlyTourRepository extends BaseRepository
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
        return MonthlyTour::class;
    }
}
