<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreVehiculoRequest extends FormRequest
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
        return [
            'placa' => 'required|string|max:10|unique:vehiculos,placa',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'fecha_fabricacion' => 'required|date|before_or_equal:today',
            'contacto_id' => 'required|exists:contactos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'placa.required' => 'La placa es obligatoria.',
            'placa.unique' => 'Esta placa ya está registrada.',
            'placa.max' => 'La placa no puede tener más de 10 caracteres.',

            'marca.required' => 'La marca es obligatoria.',
            'marca.max' => 'La marca no puede tener más de 50 caracteres.',

            'modelo.required' => 'El modelo es obligatorio.',
            'modelo.max' => 'El modelo no puede tener más de 50 caracteres.',

            'fecha_fabricacion.required' => 'La fecha de fabricación es obligatoria.',
            'fecha_fabricacion.date' => 'La fecha de fabricación debe ser una fecha válida.',
            'fecha_fabricacion.before_or_equal' => 'La fecha de fabricación no puede ser futura.',

            'contacto_id.required' => 'El contacto es obligatorio.',
            'contacto_id.exists' => 'El contacto seleccionado no existe.',
        ];
    }
}
