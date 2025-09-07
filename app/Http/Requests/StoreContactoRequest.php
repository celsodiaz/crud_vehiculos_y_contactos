<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.unique' => 'Este número de documento ya está registrado.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'El correo electrónico debe tener un formato válido.',
            'correo.unique' => 'Este correo electrónico ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
        ];
    }


    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
    throw new \Illuminate\Http\Exceptions\HttpResponseException(
        response()->json([
            'message' => 'Errores de validación',
            'errors'  => $validator->errors(), 
        ], 422)
    );
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'nro_documento' => 'required|string|max:20|unique:contactos,nro_documento',
            'correo' => 'required|email|unique:contactos,correo',
            'telefono' => 'required|string|max:20',
        ];
    }
}


