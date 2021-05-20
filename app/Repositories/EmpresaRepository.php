<?php

namespace App\Repositories;


use App\Empresa;
use InfyOm\Generator\Common\BaseRepository;
//use InfyOm\Generator\Common\BaseRepository;

class EmpresaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'codigo',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Empresa::class;
    }   

    public function getByFilter($pagination,$filters,$with=null){
        $query = $this->model->newQuery();

        if ($with!=null){
            $query = $this->model->newQuery()->with($with);
        }

        foreach ($filters as $key => $value) {
            if ($value!=""){
                if (substr($key, -3) == "_id"){
                    $query = $query->where($key,$value);        
                }else{
                    $query = $query->where($key,"like","%" . $value . "%");        
                }                
            }
        }

        $query->orderBy('nombre');

        if (is_null($pagination)){
            return $query = $query->get();
        }else{
            return $query = $query->paginate($pagination);    
        }
        
    }    
}
