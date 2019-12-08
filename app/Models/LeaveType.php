<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LeaveType
 * @package App\Models
 * @version December 8, 2019, 4:44 pm UTC
 *
 * @property string name
 * @property integer days_per_year
 * @property string description
 */
class LeaveType extends Model
{
    use SoftDeletes;

    public $table = 'leave_types';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'days_per_year',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'days_per_year' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'days_per_year' => 'required'
    ];

    
}
