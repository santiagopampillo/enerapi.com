<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\ProductoSubcategoria;

class UpdateProductoSubcategoriaRequest extends FormRequest
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
        $rules = ProductoSubcategoria::$rules;
        $rules['nombre'] = str_replace('{:id}',$this->get('id'),$rules['nombre']); 
        return $rules;
    }
}
