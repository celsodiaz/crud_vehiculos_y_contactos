<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    protected $safeParams = [];
    protected $columnMap = [];
    
    protected $operatorMap = [
        'eq' => '=',        // igual exacto
        'like' => 'LIKE',   // búsqueda parcial  
        'gte' => '>=',      // mayor o igual (para fechas)
        'lte' => '<=',      // menor o igual (para fechas)
    ];

    public function transform(Request $request)
    {
        $eloQuery = [];
        
        foreach ($this->safeParams as $parm => $operators) {
            $query = $request->query($parm);
            
            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $value = $query[$operator];
                    
                    // Para LIKE, agregar % automáticamente
                    if ($operator === 'like') {
                        $value = "%{$value}%";
                    }

                    $eloQuery[] = [$column, $this->operatorMap[$operator], $value];
                }
            }
        }

        return $eloQuery;
    }
}