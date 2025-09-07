<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateVehiculoRequest extends FormRequest
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
        $vehiculoId = $this->route('vehiculo')->id;

        $rules = [
            'placa' => [
                'required',
                'string',
                'max:10',
                Rule::unique('vehiculos', 'placa')->ignore($vehiculoId),
            ],
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'fecha_fabricacion' => 'required|date',
            'contacto_id' => 'required|exists:contactos,id',
        ];

        // 🔹 Si el método es PATCH, hacemos que los campos sean opcionales
        if ($this->method() === 'PATCH') {
            foreach ($rules as $key => $rule) {
                // reemplaza "required|" si existe
                $rules[$key] = str_replace('required|', '', $rule);
                // y también elimina "required" solito
                if ($rules[$key] === 'required') {
                    $rules[$key] = '';
                }
            }
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            'placa.required' => 'La placa es obligatoria.',
            'placa.unique' => 'Esta placa ya está registrada.',
            'placa.max' => 'La placa no puede tener más de 10 caracteres.',

            'marca.required' => 'La marca es obligatoria.',
            'marca.string' => 'La marca debe ser una cadena de texto.',
            'marca.max' => 'La marca no puede tener más de 100 caracteres.',

            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.string' => 'El modelo debe ser una cadena de texto.',
            'modelo.max' => 'El modelo no puede tener más de 100 caracteres.',

            'fecha_fabricacion.required' => 'La fecha de fabricación es obligatoria.',
            'fecha_fabricacion.date' => 'La fecha de fabricación debe ser una fecha válida.',

            'contacto_id.required' => 'El contacto asociado es obligatorio.',
            'contacto_id.exists' => 'El contacto seleccionado no existe en el sistema.',
        ];
    }
}
