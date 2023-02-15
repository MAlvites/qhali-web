<?php

namespace App\Exceptions;

use Exception;

class ChangePasswordUnauthorizeException extends Exception
{
    protected $message = "Cambio de contraseña no autorizado.";
}
