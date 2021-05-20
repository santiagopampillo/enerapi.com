<?php

namespace App\Repositories;

use App\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version November 10, 2017, 8:03 pm UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name'=>'like',
        'email'=>'like',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function create(array $attributes)
    {       
        $object = parent::create($attributes);
        
        if (!$object)
        {
            return FALSE;
        }
        
               
        return $object;
        
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

        
        if (is_null($pagination)){
            return $query = $query->get();
        }else{
            return $query = $query->paginate($pagination);    
        }
        
    } 

}
