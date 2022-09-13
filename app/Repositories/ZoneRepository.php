<?php

namespace App\Repositories;

use App\Models\Zone;
use App\Repositories\BaseRepository;

/**
 * Class ZoneRepository
 * @package App\Repositories
 * @version March 15, 2022, 2:43 pm +0545
*/

class ZoneRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'zone'
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
        return Zone::class;
    }
}
