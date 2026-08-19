<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\DB;

abstract class Service
{
    protected function transaction(Closure $callback): mixed
    {
        return DB::transaction($callback);
    }
}