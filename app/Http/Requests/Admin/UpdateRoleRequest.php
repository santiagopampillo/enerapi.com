<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Role;

class UpdateRoleRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
           'name.required' => 'El campo nombre es requerido.',
           'name.unique' => 'El campo nombre ya ha sido tomado.',
        ];
    }    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return str_replace(':id',$this->get('id'),Role::$rules);
    }
}
