<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Errores de validación',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }

    public function rules(): array
    {
        $contactoId = $this->route('contacto')->id;

        $rules = [
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'nro_documento' => [
                'required',
                'string',
                'max:20',
                Rule::unique('contactos', 'nro_documento')->ignore($contactoId),
            ],
            'correo' => [
                'required',
                'email',
                Rule::unique('contactos', 'correo')->ignore($contactoId),
            ],
            'telefono' => 'required|string|max:20',
        ];

        // 🔹 Si es PATCH, quitar el "required"
        if ($this->isMethod('patch')) {
            foreach ($rules as $key => $rule) {
                if (is_string($rule)) {
                    $rules[$key] = str_replace('required|', '', $rule);
                    $rules[$key] = str_replace('required', '', $rules[$key]);
                } elseif (is_array($rule)) {
                    // elimina 'required' del array
                    $rules[$key] = array_filter($rule, fn($r) => $r !== 'required');
                }
            }
        }

        return $rules;
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
}
