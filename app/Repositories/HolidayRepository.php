<?php

namespace App\Repositories;

use App\Models\Holiday;
use App\Repositories\BaseRepository;

/**
 * Class HolidayRepository
 * @package App\Repositories
 * @version December 8, 2019, 4:40 pm UTC
*/

class HolidayRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'start_date',
        'end_date'
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
        return Holiday::class;
    }
}
