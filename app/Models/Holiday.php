<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Holiday
 * @package App\Models
 * @version December 8, 2019, 4:40 pm UTC
 *
 * @property string title
 * @property string|\Carbon\Carbon start_date
 * @property string|\Carbon\Carbon end_date
 */
class Holiday extends Model
{
    use SoftDeletes;

    public $table = 'holidays';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'start_date' => 'required',
        'end_date' => 'required'
    ];

    
}
