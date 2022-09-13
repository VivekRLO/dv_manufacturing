<?php

namespace App\Repositories;

use App\Models\Channel;
use App\Repositories\BaseRepository;

/**
 * Class ChannelRepository
 * @package App\Repositories
 * @version March 15, 2022, 2:41 pm +0545
*/

class ChannelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'channel'
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
        return Channel::class;
    }
}
