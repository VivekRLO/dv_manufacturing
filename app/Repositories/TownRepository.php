<?php

namespace App\Repositories;

use App\Models\Town;
use App\Repositories\BaseRepository;

/**
 * Class TownRepository
 * @package App\Repositories
 * @version March 15, 2022, 2:44 pm +0545
*/

class TownRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'town'
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
        return Town::class;
    }
}
