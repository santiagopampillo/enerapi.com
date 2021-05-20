<?php
namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioApi extends Model
{
    use SoftDeletes;

    public $table = 'usuarios_api';
    
    protected $dates = [];

    public $fillable = [
        'email',
        'fecha_desde',
        'fecha_hasta',
        'api_secret'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'api_secret' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required',
        'fecha_desde' => 'required',
        'fecha_hasta' => 'required'
    ];

    
}
