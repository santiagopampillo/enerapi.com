<?php

namespace App\Repositories;

use App\UsuarioApi;
use InfyOm\Generator\Common\BaseRepository;
//use InfyOm\Generator\Common\BaseRepository;

class UsuarioApiRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email',
        'fecha_desde',
        'fecha_hasta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UsuarioApi::class;
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

        $query->orderBy('email');

        if (is_null($pagination)){
            return $query = $query->get();
        }else{
            return $query = $query->paginate($pagination);    
        }
        
    }    
}
