<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\DB;

abstract class Service
{
    /**
     * Ejecuta una operación de escritura dentro de una transacción.
     */
    protected function transaction(Closure $callback): mixed
    {
        return DB::transaction($callback);
    }
}