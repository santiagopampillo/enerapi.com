<?php

namespace App\Repositories;


use App\DatoDDJJ;
use InfyOm\Generator\Common\BaseRepository;
//use InfyOm\Generator\Common\BaseRepository;

class DatoDDJJRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'empresa',
        'mes',
        'anio',
        'cuenca'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DatoDDJJ::class;
    }   

    public function getByFilter($pagination,$filters,$with=null){
        $query = $this->model->newQuery();

        $query=$query->join('empresas', 'empresas.id', '=', 'datos_ddjj.empresa_id');
        $query=$query->select('datos_ddjj.*');

        if ($with!=null){
            $query = $this->model->newQuery()->with($with);
        }

        foreach ($filters as $key => $value) {
            if ($value!=""){
                if (substr($key, -3) == "_id"){
                    $query = $query->where($key,$value);        
                }else{
                    if($key == "empresa")
                        $query = $query->where("empresas.id","=",$value); 
                    elseif($key == "sigla"){
                        $query = $query->where("datos_ddjj.sigla","like","%" . $value . "%");                            
                    }
                    elseif($key == "mes" ||  $key =="anio")  
                        if($value != "") 
                            $query = $query->where($key,"=",$value);        
                    else
                        $query = $query->where($key,"like","%" . $value . "%");        
                }                
            }
        }

        $query->orderBy('empresas.nombre');

        if (is_null($pagination)){
            return $query = $query->get();
        }else{
            return $query = $query->paginate($pagination);    
        }
        
    }    

    public function filtrar($request){
        $query = $this->model->newQuery();
        $query=$query->join('empresas', 'empresas.id', '=', 'datos_ddjj.empresa_id');
        
        if(isset($request["codigo"]) && $request["codigo"]!="")
            $query=$query->where("empresas.codigo","=", $request["codigo"]);
        if(isset($request["anio"]) && $request["anio"]!="")
            $query=$query->where("datos_ddjj.anio","=", $request["anio"]);  
        if(isset($request["mes"]) && $request["mes"]!="")
            $query=$query->where("datos_ddjj.mes","=", $request["mes"]); 
        if(isset($request["cuenca"]) && $request["cuenca"]!="")
            $query=$query->where("datos_ddjj.cuenca","=", $request["cuenca"]); 
        if(isset($request["yacimiento"]) && $request["yacimiento"]!="")
            $query=$query->where("datos_ddjj.yacimiento","=", $request["yacimiento"]); 
        if(isset($request["id_pozo"]) && $request["id_pozo"]!="")
            $query=$query->where("datos_ddjj.id_pozo","=", $request["id_pozo"]);         

        $query=$query->select("empresas.nombre", "empresas.codigo", "datos_ddjj.mes", "datos_ddjj.anio", "datos_ddjj.nombre_archivo", 
                                "datos_ddjj.cuenca", "datos_ddjj.provincia", "datos_ddjj.area", "datos_ddjj.yacimiento", 
                                "datos_ddjj.id_pozo", "datos_ddjj.sigla", "datos_ddjj.form_prod", "datos_ddjj.cod_propio", 
                                "datos_ddjj.nom_propio", "datos_ddjj.prod_men_pet", "datos_ddjj.prod_men_gas", 
                                "datos_ddjj.prod_men_agua", "datos_ddjj.prod_acum_pet", "datos_ddjj.prod_acum_gas", 
                                "datos_ddjj.prod_acum_agua", "datos_ddjj.iny_agua", "datos_ddjj.iny_gas", "datos_ddjj.iny_cO2", 
                                "datos_ddjj.iny_otros", "datos_ddjj.rgp", "datos_ddjj.porc_de_agua", "datos_ddjj.tef", 
                                "datos_ddjj.vida_util", "datos_ddjj.sist_extrac", "datos_ddjj.est_pozo", "datos_ddjj.tipo_pozo", 
                                "datos_ddjj.clasificacion", "datos_ddjj.sub_clasificacion", "datos_ddjj.tipo_de_recurso", 
                                "datos_ddjj.sub_tipo_de_recurso", "datos_ddjj.observaciones", "datos_ddjj.latitud", 
                                "datos_ddjj.longitud", "datos_ddjj.cota", "datos_ddjj.profundidad");
        $query->orderBy('empresas.nombre');

        return $query = $query->get();

    } 
}
