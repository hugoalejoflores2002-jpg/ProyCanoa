<?php

namespace App\Exceptions\Domain;

use Exception;

abstract class DomainException extends Exception
{
    /**
     * Código HTTP con el que se responde esta excepción.
     */
    public function status(): int
    {
        return 422;
    }
}