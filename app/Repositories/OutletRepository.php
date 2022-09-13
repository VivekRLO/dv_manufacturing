<?php

namespace App\Repositories;

use App\Models\Outlet;
use App\Repositories\BaseRepository;

/**
 * Class OutletRepository
 * @package App\Repositories
 * @version April 7, 2021, 4:41 am UTC
*/

class OutletRepository extends BaseRepository
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
        return Outlet::class;
    }
}
