<?php

namespace App\Repositories;

use App\Models\SaleReturn;
use App\Repositories\BaseRepository;

/**
 * Class SaleReturnRepository
 * @package App\Repositories
 * @version February 1, 2022, 11:16 am +0545
*/

class SaleReturnRepository extends BaseRepository
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
        return SaleReturn::class;
    }
}
