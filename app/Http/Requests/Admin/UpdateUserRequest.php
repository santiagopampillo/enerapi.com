<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UpdateUserRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->get('id').',id',
            'rol_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
           'first_name.required' => 'El campo nombre es requerido.',
           'last_name.required' => 'El campo apellido es requerido.',
           'email.required' => 'El campo email es requerido.',
        ];
    }
}
