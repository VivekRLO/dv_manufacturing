<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Repositories\BaseRepository;

/**
 * Class CollectionRepository
 * @package App\Repositories
 * @version April 11, 2021, 2:37 pm +0545
*/

class CollectionRepository extends BaseRepository
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
        return Collection::class;
    }
}
