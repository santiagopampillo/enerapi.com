<?php
namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procesamiento extends Model
{
    use SoftDeletes;

    public $table = 'procesamientos';
    
    protected $dates = [];

    public $fillable = [
        'anio',
        'empresa_id',
        'procesamiento_archivo_id',
        'codigo',
        'mes',
        'fecha',
        'estado'
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
