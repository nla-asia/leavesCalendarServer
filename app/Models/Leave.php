<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Leave
 * @package App\Models
 * @version December 8, 2019, 3:03 pm UTC
 *
 * @property integer employer_id
 * @property integer type
 * @property string|\Carbon\Carbon start_date
 * @property string|\Carbon\Carbon end_date
 * @property string reason
 * @property integer status
 */
class Leave extends Model
{
    use SoftDeletes;

    public $table = 'leaves';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'employee_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'type' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'reason' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
     //   'employee_id' => 'required',
        'type' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'reason' => 'required'
    ];

    
}
