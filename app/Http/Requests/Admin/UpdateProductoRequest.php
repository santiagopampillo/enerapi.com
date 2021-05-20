<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Producto;

class UpdateProductoRequest extends FormRequest
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
        $rules = Producto::$rules;
        $rules['nombre'] = str_replace('{:id}',$this->get('id'),$rules['nombre']); 
        return $rules;
    }
}
