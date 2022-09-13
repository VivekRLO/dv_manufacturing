<?php

namespace App\Repositories;

use App\Models\Street;
use App\Repositories\BaseRepository;

/**
 * Class StreetRepository
 * @package App\Repositories
 * @version April 6, 2021, 9:54 am UTC
*/

class StreetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'area_id',
        'name'
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
        return Street::class;
    }
}
