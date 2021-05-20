<?php
namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcesamientoArchivo extends Model
{
    use SoftDeletes;

    public $table = 'procesamientos_archivos';
    
    protected $dates = [];

    public $fillable = [
        'anio',
        'empresa_id',
        'codigo',
        'mes',
        'fecha',
        'estado',
        'estado_proceso_datos'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'codigo' => 'string',
        'estado' => 'string',
        'anio' => 'integer',
        'mes' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'codigo' => 'required',
        'estado' => 'required',
        'anio' => 'required',
        'mes' => 'required',
        'fecha' => 'required'
    ];


    
}
