<?php
namespace App;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatoDDJJ extends Model
{
    use SoftDeletes;

    public $table = 'datos_ddjj';
    
    protected $dates = [];

    public $fillable = [
        'id',
        'empresa_id',
        'procesamiento_id',
        'mes',
        'anio',
        'nombre_archivo',
        'cuenca', 
        'provincia', 
        'area', 
        'yacimiento', 
        'id_pozo', 
        'sigla', 
        'form_prod', 
        'cod_propio', 
        'nom_propio', 
        'prod_men_pet', 
        'prod_men_gas', 
        'prod_men_agua', 
        'prod_acum_pet', 
        'prod_acum_gas', 
        'prod_acum_agua', 
        'iny_agua', 
        'iny_gas', 
        'iny_cO2', 
        'iny_otros', 
        'rgp', 
        'porc_de_agua', 
        'tef', 
        'vida_util', 
        'sist_extrac', 
        'est_pozo', 
        'tipo_pozo', 
        'clasificacion', 
        'sub_clasificacion', 
        'tipo_de_recurso', 
        'sub_tipo_de_recurso', 
        'observaciones', 
        'latitud', 
        'longitud', 
        'cota', 
        'profundidad',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function empresa()
    {
        return $this->hasOne('App\Empresa', 'id', 'empresa_id');
    }
    
}
