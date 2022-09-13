<?php

namespace App\Repositories;

use App\Models\AppVersion;
use App\Repositories\BaseRepository;

/**
 * Class AppVersionRepository
 * @package App\Repositories
 * @version April 22, 2021, 4:20 pm +0545
*/

class AppVersionRepository extends BaseRepository
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
        return AppVersion::class;
    }
}
