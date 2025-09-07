<?php

namespace App\Filters;
use App\Filters\ApiFilter;

class ContactoFilter extends ApiFilter
{
    protected $safeParams = [
        'nombre' => ['eq', 'like'],
        'apellidos' => ['eq', 'like'],
        'documento' => ['eq', 'like'],
        'correo' => ['eq', 'like'],
        'telefono' => ['eq', 'like'],
    ];

    protected $columnMap = [
        'documento' => 'nro_documento',
    ];
}
