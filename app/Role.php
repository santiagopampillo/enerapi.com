<?php

namespace App;

use Eloquent as Model;

/**
 * Class Role
 * @package App
 * @version November 13, 2017, 5:53 pm UTC
 *
 * @property string name
 */
class Role extends Model
{

    public $table = 'roles';

    public $fillable = [
        'name',
        'guard_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:roles,name,:id,id',
        'permisos' => 'required'
    ];

    public function permisos()
    {
        return $this->belongsToMany('App\Permiso', 'roles_permisos', 'role_id', 'permiso_id');
    }
    
}
