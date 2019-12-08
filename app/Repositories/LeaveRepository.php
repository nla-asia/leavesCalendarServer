<?php

namespace App\Repositories;

use App\Models\Leave;
use App\Repositories\BaseRepository;

/**
 * Class LeaveRepository
 * @package App\Repositories
 * @version December 8, 2019, 3:03 pm UTC
*/

class LeaveRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employer_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status'
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
        return Leave::class;
    }

    
}
