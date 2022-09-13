<?php

namespace App\Repositories;

use App\Models\StockCount;
use App\Repositories\BaseRepository;

/**
 * Class StockCountRepository
 * @package App\Repositories
 * @version September 6, 2021, 12:30 pm +0545
*/

class StockCountRepository extends BaseRepository
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
        return StockCount::class;
    }
}
