<?php

namespace App\Repositories;

use App\Models\RouteName;
use App\Repositories\BaseRepository;

/**
 * Class RouteNameRepository
 * @package App\Repositories
 * @version March 15, 2022, 3:04 pm +0545
*/

class RouteNameRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'routename'
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
        return RouteName::class;
    }
}
