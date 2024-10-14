<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct($message = "No se puede reducir la cantidad por debajo de 0.", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
