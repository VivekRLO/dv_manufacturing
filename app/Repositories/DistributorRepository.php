<?php

namespace App\Repositories;

use App\Models\Distributor;
use App\Repositories\BaseRepository;

/**
 * Class DistributorRepository
 * @package App\Repositories
 * @version April 7, 2021, 10:11 am UTC
*/

class DistributorRepository extends BaseRepository
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
        return Distributor::class;
    }
}
