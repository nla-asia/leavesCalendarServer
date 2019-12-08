<?php

namespace App\Repositories;

use App\Models\LeaveType;
use App\Repositories\BaseRepository;

/**
 * Class LeaveTypeRepository
 * @package App\Repositories
 * @version December 8, 2019, 4:44 pm UTC
*/

class LeaveTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'days_per_year',
        'description'
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
        return LeaveType::class;
    }
}
