<?php

namespace App\Filters;
use App\Filters\ApiFilter;

class VehiculoFilter extends ApiFilter
{
    protected $safeParams = [
        'placa' => ['eq', 'like'],
        'marca' => ['eq', 'like'],
        'modelo' => ['eq', 'like'],
        'fecha' => ['eq', 'gte', 'lte'],
        'clienteId' => ['eq'],
    ];

    protected $columnMap = [
        'fecha' => 'fecha_fabricacion',
        'clienteId' => 'contacto_id',
    ];
}