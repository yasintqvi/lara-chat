<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidLoginCredentialException extends BaseException
{
    public function __construct()
    {
        $message = __('exceptions.invalid_login_credential');

        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
