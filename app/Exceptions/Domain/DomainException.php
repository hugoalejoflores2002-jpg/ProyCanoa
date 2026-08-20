<?php

namespace App\Exceptions\Domain;

use Exception;

abstract class DomainException extends Exception
{
    public function status(): int
    {
        return 422;
    }
}