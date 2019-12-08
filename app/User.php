<?php

namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * Class User
 * @package App
 * @version December 8, 2019, 10:35 am UTC
 *
 * @property string name
 * @property string designation
 * @property string email
 * @property string phone
 * @property string password
 */
class User extends Authenticatable  implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    public $table = 'employees';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'designation',
        'email',
        'phone',
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'designation' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'designation' => 'required',
        'email' => 'required|unique:employees',
        'phone' => 'required',
        'password' => 'required'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    
}
