<?php

namespace App\Repositories;

use App\Models\StockHistory;
use App\Repositories\BaseRepository;

/**
 * Class StockHistoryRepository
 * @package App\Repositories
 * @version April 7, 2021, 11:22 am UTC
*/

class StockHistoryRepository extends BaseRepository
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
        return StockHistory::class;
    }
}
